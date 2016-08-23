<?php
/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 16/08/2016
 * Time: 11:45
 */

namespace WonderWp\Plugin\Translator;

class TranslatorGetTextService
{

    public function locateFiles($path, $name, $type)
    {
        $translationFiles = array('pot' => '', 'po' => array());

        /*
         * load and locate pot, / po files
         */
        if (empty($path) || !isset($name) || empty($type)) {
            throw new Exception(Loco::__('Invalid data posted to server'), 422);
        }
        // path is allowed to not exist yet
        if ('/' !== $path{0}) {
            $path = WP_CONTENT_DIR . '/' . $path;
        }

        // but package must exist so we can get POT or source
        /* @var $package LocoPackage */
        $package = LocoPackage::get($name, $type);
        if (!$package) {
            throw new Exception(sprintf(Loco::__('Package not found called %s'), $name), 404);
        }
        $translationFiles['pot'] = $package->get_pot();
        $translationFiles['po'] = $package->get_po();

        return $translationFiles;
    }

    public function getTranslationsFromFiles($translationFiles)
    {
        /*
         * Parse pot / po files
         */
        $translations = array();

        if (!empty($translationFiles['po'])) {
            foreach ($translationFiles['po'] as $locale => $languageFile) {
                $parsedLanguageFile = LocoAdmin::parse_po($languageFile);
                if (empty($translations[$locale])) {
                    $translations[$locale] = array();
                }

                if (!empty($parsedLanguageFile)) {
                    foreach ($parsedLanguageFile as $i => $translatedKey) {
                        if ($i === 0) {
                            $translations[$locale]['headers'] = loco_parse_po_headers($translatedKey['target']);
                        } else {
                            $translations[$locale]['lines'][$translatedKey['source']] = $translatedKey['target'];
                        }
                    }
                }
            }
        }

        return $translations;
    }

    public function prepareTranslationTable($translationFiles, $languages)
    {

        $translations = $this->getTranslationsFromFiles($translationFiles);

        $tableHidden = array();

        /*
         * Parse pot / po files
         */
        /** @var \LocoHeaders $potHeaders */
        $potHeaders = array();
        $pot = LocoAdmin::parse_po_with_headers($translationFiles['pot'], $potHeaders);
        $potHeaders->offsetSet('X-Generator', 'wonderwp');
        $tableHidden['pot'] = serialize($potHeaders->jsonSerialize());

        /*
         * Build up translation table
         */
        $tableHeaders = array(
            'Clé de traduction'
        );
        if (!empty($languages)) {
            foreach ($languages as $activeLang) {
                /** @var $activeLang LangEntity */
                $locale = $activeLang->getLocale();
                $tableHeaders[] = $activeLang->getTitle();
                $tableHidden[$locale] = !empty($translations[$locale]['headers']) ? serialize($translations[$locale]['headers']->jsonSerialize()) : serialize(array());
            }
        }
        if (!empty($pot)) {
            $tableBody = array();
            foreach ($pot as $i => $translationKey) {
                if (empty($translationKey['source'])) {
                    continue;
                }
                $editionRow = array(
                    'pot' => $translationKey['source']
                );
                if (!empty($languages)) {
                    foreach ($languages as $activeLang) {
                        /** @var $activeLang LangEntity */
                        $locale = $activeLang->getLocale();
                        $translatedKey = !empty($translations[$locale]['lines'][$translationKey['source']]) ? $translations[$locale]['lines'][$translationKey['source']] : '';
                        $editionRow[$locale] = $translatedKey;
                    }
                }
                $tableBody[] = $editionRow;
            }
        }

        return array('headers' => $tableHeaders, 'body' => $tableBody, 'hidden' => $tableHidden);
    }

    public function persistTranslations($translationFiles, $newTranslations)
    {
        if (!empty($newTranslations['pot'])) {
            $locales = array_keys($newTranslations);
            $hasPot = array_search('pot', $locales);
            if ($hasPot !== false) {
                unset($locales[$hasPot]);
            }

            $potLines = array();
            $potHeaders = !empty($newTranslations['pot']['headers']) ? unserialize($newTranslations['pot']['headers']) : array();
            $potLines[] = $this->arrayToLines(array('msgid' => '', 'msgstr' => $this->arrayToLines($potHeaders)));

            if (!empty($locales)) {
                $poLines = array();
                //Generate headers for each po file from pot file template
                foreach ($locales as $locale) {
                    $poLines[$locale] = array();
                    $headers = !empty($newTranslations[$locale]['headers']) ? unserialize($newTranslations[$locale]['headers']) : $potHeaders;
                    if (empty($headers['POT-Creation-Date'])) {
                        $headers['POT-Creation-Date'] = date('r');
                    }
                    $headers['PO-Revision-Date'] = date('r');
                    $current_user = wp_get_current_user();
                    $headers['Last-Translator'] = "$current_user->user_login <$current_user->user_email>";
                    $headers['X-Generator'] = 'wonderwp';
                    $headers['X-Loco-Target-Locale'] = $locale;
                    $poLines[$locale][] = $this->arrayToLines(array('msgid' => '', 'msgstr' => $this->arrayToLines($headers)));
                }
                //Generating lines for each translation in the pot template, and in the po files as well
                foreach ($newTranslations['pot']['lines'] as $i => $translationLine) {
                    $translationData = array('msgid' => $translationLine, 'msgstr' => '');
                    $potLines[] = $this->arrayToLines($translationData);
                    foreach ($locales as $locale) {
                        $translationData['msgstr'] = !empty($newTranslations[$locale]['lines'][$i]) ? $newTranslations[$locale]['lines'][$i] : '';
                        $poLines[$locale][] = $this->arrayToLines($translationData);
                    }
                }
                //Writing pot file
                $content = implode("\n\n", $potLines);
                $destFile = $translationFiles['pot'];
                $write = file_put_contents($destFile, $content);
                if(!$write){
                    throw new Exception( Loco::__('Cannot write POT file') );
                }

                //Writing po files
                if (!empty($poLines)) {
                    foreach ($poLines as $locale=>$langTranslated) {
                        $content = implode("\n\n", $langTranslated);
                        $destFile = !empty($translationFiles['po'][$locale]) ? $translationFiles['po'][$locale] : dirname($translationFiles['pot']).'/'.str_replace('.pot','-'.$locale.'.po',basename($translationFiles['pot']));
                        $write = file_put_contents($destFile, $content);
                        if(!$write){
                            throw new Exception( Loco::__('Cannot write PO file') );
                        }

                        try {

                            // check target MO path before compiling
                            $mopath = preg_replace( '/\.po$/', '.mo', $destFile );
                            if( ! file_exists($mopath) && ! is_writable( dirname($mopath) ) ){
                                throw new Exception( Loco::__('Cannot create MO file') );
                            }
                            else if( file_exists($mopath) && ! is_writable($mopath) ){
                                throw new Exception( Loco::__('Cannot overwrite MO file') );
                            }

                            // attempt to compile MO direct to file via shell
                            if( $msgfmt = LocoAdmin::msgfmt_command() ){
                                try {
                                    $bytes = 0;
                                    loco_require('build/shell-compiled');
                                    define( 'WHICH_MSGFMT', $msgfmt );
                                    $mopath = loco_compile_mo_file( $destFile, $mopath );
                                    $bytes  = $mopath && file_exists($mopath) ? filesize($mopath) : 0;
                                }
                                catch( Exception $Ex ){
                                    error_log( $Ex->getMessage(), 0 );
                                }
                                if( ! $bytes ){
                                    throw new Exception( sprintf( Loco::__('Failed to compile MO file with %s, check your settings'), WHICH_MSGFMT ) );
                                }
                                $response['compiled'] = $bytes;
                                break;
                            }

                            // Fall back to in-built MO compiler - requires PO is parsed too
                            $po = LocoAdmin::parse_po($destFile);
                            $mo = LocoAdmin::msgfmt_native($po);
                            $bytes = file_put_contents( $mopath, $mo );
                            if( ! $bytes ){
                                throw new Exception( Loco::__('Failed to write MO file') );
                            }
                            $response['compiled'] = $bytes;

                        }
                        catch( Exception $e ){
                            $response['compiled'] = $e->getMessage();
                        }
                    }
                }
            }
        }
    }

    public function arrayToLines($array)
    {
        $lines=array();
        if (!empty($array)) {
            foreach ($array as $key => $val) {
                $lines[] = trim($key) . ' "' . $val.'"';
            }
        }
        return implode("\n",$lines);
    }

}