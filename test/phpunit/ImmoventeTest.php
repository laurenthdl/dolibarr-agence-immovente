<?php
declare(strict_types=1);
require_once __DIR__ . '/bootstrap.php';
require_once __DIR__ . '/../../class/immomandatvente.class.php';
class ImmoventeTest extends PHPUnit\Framework\TestCase {
    /** @test */ public function mandatClassShouldExist(): void { $this->assertTrue(class_exists('ImmoMandatVente')); }
    /** @test */ public function commissionShouldBeCalculatedCorrectly(): void {
        $m = new ImmoMandatVente(new DoliDB()); $m->prix_net_vendeur = 50000000; $m->commission_type = 'POURCENTAGE'; $m->commission_valeur = 5;
        $this->assertEquals(2500000, $m->calculCommission());
    }
    /** @test */ public function uiFilesShouldExist(): void {
        $this->assertFileExists(__DIR__ . '/../../index.php'); $this->assertFileExists(__DIR__ . '/../../card.php');
    }
}
