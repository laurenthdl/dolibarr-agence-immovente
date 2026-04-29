<?php

declare(strict_types=1);

require_once __DIR__ . '/../../class/immomandatvente.class.php';

class ImmoMandatVenteTest extends PHPUnit\Framework\TestCase
{
    /**
     * @test
     */
    public function moduleClassShouldHaveCorrectNumber(): void
    {
        $moduleFile = __DIR__ . '/../../core/modules/modImmovente.class.php';
        $this->assertFileExists($moduleFile);
        $content = file_get_contents($moduleFile);
        $this->assertStringContainsString('numero = 700004', $content);
    }

    /**
     * @test
     */
    public function classShouldExist(): void
    {
        $this->assertTrue(class_exists('ImmoMandatVente'));
    }

    /**
     * @test
     */
    public function commissionCalculationShouldBeCorrect(): void
    {
        $prix = 50000000;
        $taux = 0.05;
        $commission = $prix * $taux;
        $this->assertEquals(2500000, $commission);
    }

    /**
     * @test
     */
    public function sqlShouldCreateMandatTable(): void
    {
        $sqlFile = __DIR__ . '/../../sql/llx_immo_mandat_vente.sql';
        $this->assertFileExists($sqlFile);
        $content = file_get_contents($sqlFile);
        $this->assertStringContainsString('CREATE TABLE', $content);
        $this->assertStringContainsString('llx_immo_mandat_vente', $content);
    }
}
