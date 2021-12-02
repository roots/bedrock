<!-- components/components/telechargement.php -->
<p class="subTitle">Composant du plugin Téléchargement</p>

<div class="encadre">
    <div class="grid-2 has-gutter-xl">
        <div>
            <p>ATTRIBUTS :</p>
            <ul>
                <li>Nom</li>
                <li>Nom du fichier</li>
                <li>Taille du fichier</li>
                <li>Type du fichier</li>
                <li>Url du fichier</li>
            </ul>
        </div>
        <div>
            <p>OPTIONS :</p>
            <ul>
            </ul>
        </div>
    </div>
</div>
<?php
$downloadComponentClass = '\WonderWp\Plugin\Download\Component\DownloadComponent';
if (class_exists($downloadComponentClass)) {
    $download = new $downloadComponentClass();

    $download
        ->setName('Déclarer son salarié')
        ->setLink('/')
        ->setFilename('declarer-son-salarie')
        ->setFileSize('75 Ko')
        ->setFileType('PDF')
        ->setTextDownload('Télécharger');

    echo $download->getMarkup();
    echo $download->getMarkup();
    echo $download->getMarkup();
} else {
    echo 'Warning : Component ' . $downloadComponentClass . ' not found';
}
