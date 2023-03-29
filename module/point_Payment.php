<?php
/*
 * @ https://EasyToYou.eu - IonCube v10 Decoder Online
 * @ PHP 5.6
 * @ Decoder version: 1.0.4
 * @ Release: 02/06/2020
 *
 * @ ZendGuard Decoder PHP 5.6
 */

App::uses("Controller", "Controller");
class AppController extends Controller
{
    public function beforeRender()
    {
        parent::beforeRender();
        $this->loadModel("HtmlPart");
        $this->set("HTML_HEADER_LOGO", $this->HtmlPart->getHtml(HtmlPart::HEADER_LOGO));
        $this->set("HTML_LEFT_TOP", $this->HtmlPart->getHtml(HtmlPart::LEFT_TOP));
    }
}

?>