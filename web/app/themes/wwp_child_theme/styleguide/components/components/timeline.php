<!-- components/components/timeline.php -->
<div class="encadre">
    <div class="grid-2 has-gutter-xl">
        <div>
            <p>ATTRIBUTS :</p>
            <ul>
                <li>Date (date)</li>
                <li>Texte (text)</li>
                <li>Image (img)</li>
                <li>Lien (link)</li>
                <li>Image (img)</li>
                <li>Classe (liClass)</li>

            </ul>
        </div>
        <div>
            <p>OPTIONS :</p>
            <ul>
                <li>Horizontal (class="horizontal")</li>
                <li>Horizontal (class="vertical")</li>
            </ul>
        </div>
    </div>
</div>

<?php

echo do_shortcode('[timeline class="horizontal"][timeline-item text="test"][/timeline]');
