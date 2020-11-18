<?php

namespace WonderWp\Theme\Child\Service;

use WonderWp\Component\PluginSkeleton\Service\RegistrableInterface;
use WP_Customize_Image_Control;
use WP_Customize_Manager;

class ThemeCustomizerService implements RegistrableInterface
{

    const HeaderSection                 = 'wwp-theme-header';
    const HeaderLogoMod                 = "HeaderLogo";
    const HeaderFixedMod                = 'isFixed';
    const MobileMenuVariationMod        = 'MobileMenuVariation';
    const MobileMenuVariation_Panel     = 'panel';
    const MobileMenuVariation_Accordion = 'accordion';

    /**
     * @var WP_Customize_Manager
     */
    protected WP_Customize_Manager $wp_customize;

    /**
     * @param WP_Customize_Manager $wp_customize
     *
     * @return static
     */
    public function setWpCustomize(WP_Customize_Manager $wp_customize)
    {
        $this->wp_customize = $wp_customize;

        return $this;
    }

    public function register()
    {
        $this->addHeaderSection();
    }

    protected function addHeaderSection()
    {
        $sectionId = self::HeaderSection;
        $this->wp_customize->add_section(
            $sectionId,
            [
                'title'    => 'Options du header',
                'priority' => 200,
            ]
        );

        $this->addLogoSetting($sectionId);
        $this->addStickyHeaderSetting($sectionId);
        $this->addMobileMenuVariationSetting($sectionId);

    }

    protected function addLogoSetting($sectionId)
    {
        $settingId = $sectionId . self::HeaderLogoMod;
        $this->wp_customize->add_setting(
            $settingId,
            [
                'default'   => '',
                'transport' => 'postMessage',
            ]
        );
        $this->wp_customize->add_control(
            new WP_Customize_Image_Control(
                $this->wp_customize,
                $settingId,
                [
                    'label'    => 'Logo du header',
                    'settings' => $settingId,
                    'section'  => $sectionId,
                ]
            )
        );
    }

    protected function addStickyHeaderSetting($sectionId)
    {
        $settingId = $sectionId . self::HeaderFixedMod;
        $this->wp_customize->add_setting(
            $settingId,
            [
                'default'   => 'true',
                'transport' => 'postMessage',
            ]
        );
        $this->wp_customize->add_control(
            $settingId,
            [
                'section' => $sectionId,
                'label'   => 'Header sticky',
                'type'    => 'checkbox',
            ]
        );
    }

    protected function addMobileMenuVariationSetting($sectionId)
    {
        $settingId = $sectionId . self::MobileMenuVariationMod;
        $this->wp_customize->add_setting(
            $settingId,
            [
                'default'   => 'true',
                'transport' => 'postMessage',
            ]
        );
        $this->wp_customize->add_control(
            $settingId,
            [
                'section' => $sectionId,
                'label'   => 'Variante du Menu Mobile',
                'type'    => 'radio',
                'choices' => [
                    self::MobileMenuVariation_Panel     => 'Panel',
                    self::MobileMenuVariation_Accordion => 'Accordéon',
                ],
            ]
        );
    }

    /**
     * HOOKS
     */

    public function changeHeaderLogoHook($headerLogo)
    {
        $customizedLogo = get_theme_mod(self::HeaderSection . self::HeaderLogoMod);
        if (!empty($customizedLogo)) {
            $headerLogo = $customizedLogo;
        }

        return $headerLogo;
    }

    public function stickyHeaderHook(array $classes)
    {
        $stickyHeaderEnabled = get_theme_mod(self::HeaderSection . self::HeaderFixedMod);
        if ($stickyHeaderEnabled) {
            $classes[] = 'stickable';
        }

        return $classes;
    }

    public function mobileMenuVariationClassHook($class)
    {
        $mobileMenuVariation = get_theme_mod(self::HeaderSection . self::MobileMenuVariationMod, self::MobileMenuVariation_Panel);

        if (!empty($mobileMenuVariation)) {
            $class .= ' menu-mobile-' . $mobileMenuVariation;
        }

        return $class;
    }

}
