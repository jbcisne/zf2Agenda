<?php

/**
 * @author Michael Fernandes <cerberosnash@gmail.com>
 */
class VisualizarCaixaDeMinutasSuite4CaixasMinutasProduzidasCasoTeste026CaixaMinutasProduzidasDadosNaoEncontrados extends PHPUnit_Extensions_SeleniumTestCase {

    protected function setUp() {
        $this->setBrowser(PHPUNIT_TESTSUITE_EXTENSION_SELENIUM_BROWSER);
        $this->setBrowserUrl(PHPUNIT_TESTSUITE_EXTENSION_SELENIUM_TESTS_URL);
        $this->setHost(PHPUNIT_TESTSUITE_EXTENSION_SELENIUM_HOST);
        $this->setPort((int) PHPUNIT_TESTSUITE_EXTENSION_SELENIUM_PORT);
    }

    public function testMyTestCase() {
        $this->open("/ProjectSgdoc.VisualizarCaixaDeMinutas.Suite4CaixasMinutasProduzidas");
        $this->click("link=Add");
        $this->click("link=Test page");
        $this->waitForPageToLoad("30000");
        $this->type("id=pagename", "CasoTeste026CaixaMinutasProduzidasDadosNaoEncontrados");
        $this->type("id=pageContent", "!contents -R2 -g -p -f -h\n" . '| script | selenium driver fixture |
| start browser | firefox | on url | https://tcti.sgdoce.sisicmbio.icmbio.gov.br/ |
| save screenshot after | every step | in folder | http://files/ProjectSgdoc/testResults/screenshots/${PAGE_NAME}_on_action |
| set step delay to | slow |
| do | open | on | / |
| ensure | do | type | on | id=nuCpf | with | 737.623.851-49 |
| ensure | do | type | on | id=senha | with | 0123456789 |
| ensure | do | clickAndWait | on | css=button.btn.btn-primary |
| ensure | do | clickAndWait | on | link=Acessar » |
| do | open | on | / |
| ensure | do | click | on | link=Caixa de Minutas |
| ensure | do | clickAndWait | on | xpath=(//a[contains(text(),"Caixa de Minutas")])[2] |
| ensure | do | clickAndWait | on | link=Produzidas |
| ensure | do | waitForElementPresent | on | css=td.dataTables_empty |
| check | is | assertText | on | css=td.dataTables_empty | Não há minutas na sua caixa produzidas |
| stop browser |
');
        $this->click("name=save");
        $this->waitForPageToLoad("30000");
    }

}
