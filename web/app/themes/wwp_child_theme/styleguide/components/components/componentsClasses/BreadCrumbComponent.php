<?php
/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 15/09/2016
 * Time: 11:28
 */

namespace WonderWp\Theme\Components;


class BreadCrumbComponent extends AbstractComponent
{

    private $_crumbs = array();

    /**
     * @return array
     */
    public function getCrumbs()
    {
        return $this->_crumbs;
    }

    /**
     * @param array $crumbs
     */
    public function setCrumbs($crumbs)
    {
        $this->_crumbs = $crumbs;
        return $this;
    }

    public function getMarkup()
    {
        $markup = '';
        $breadcrumbs = $this->_crumbs;

        if (!empty($breadcrumbs)) {
            $markup .= '
            <nav>
                <ul class="breadcrumb">';
            foreach ($breadcrumbs as $breadcrumb) {
                $markup .= '
                    <li class="breadcrumb-item ' . (empty($breadcrumb['href']) ? 'active' : '') . '">';
                if (!empty($breadcrumb['href'])) {
                    $markup .= '<a href="' . $breadcrumb['href'] . '">';
                }
                $markup .= $breadcrumb['title'];
                if (!empty($breadcrumb['href'])) {
                    $markup .= '</a>';
                }
                $markup .= '</li>';
            }
            $markup .= '
                </ul>
            </nav>';
        }
        return $markup;
    }
}