<?php

use PHPUnit\Framework\TestCase;
include './src/Enana.php';

class EnanaTest extends TestCase {
    
    public function testCreandoEnana() {
        #Se probará la creación de enanas vivas, muertas y en limbo y se comprobará tanto la vida como el estado
        $enana1 = new Enana("Dori", 30); // Enana viva
        $this->assertEquals("Dori", $enana1->getNombre());
        $this->assertEquals(30, $enana1->getPuntosVida());
        $this->assertEquals("viva", $enana1->getSituacion());

        $enana2 = new Enana("Nori", -20); // Enana muerta
        $this->assertEquals("Nori", $enana2->getNombre());
        $this->assertEquals(-20, $enana2->getPuntosVida());
        $this->assertEquals("muerta", $enana2->getSituacion());

        $enana3 = new Enana("Ori", 0); // Enana en limbo
        $this->assertEquals("Ori", $enana3->getNombre());
        $this->assertEquals(0, $enana3->getPuntosVida());
        $this->assertEquals("limbo", $enana3->getSituacion());
    }
    public function testHeridaLeveVive() {
        #Se probará el efecto de una herida leve a una Enana con puntos de vida suficientes para sobrevivir al ataque
        #Se tendrá que probar que la vida es mayor que 0 y además que su situación es viva
        $enana = new Enana("Balin", 30);
        $enana->heridaLeve();
        $this->assertGreaterThan(0, $enana->getPuntosVida());
        $this->assertEquals("viva", $enana->getSituacion());

        // Probar herida leve cuando la Enana ya está en limbo
        $enana2 = new Enana("Thorin", 0);
        $enana2->heridaLeve();
        $this->assertEquals("limbo", $enana2->getSituacion());
    }

    public function testHeridaLeveMuere() {
        #Se probará el efecto de una herida leve a una Enana con puntos de vida insuficientes para sobrevivir al ataque
        #Se tendrá que probar que la vida es menor que 0 y además que su situación es muerta
        $enana = new Enana("Kili", 5);
        $enana->heridaLeve();
        $this->assertLessThan(0, $enana->getPuntosVida());
        $this->assertEquals("muerta", $enana->getSituacion());

        // Probar herida leve cuando la Enana ya está muerta
        $enana2 = new Enana("Dwalin", -15);
        $enana2->heridaLeve();
        $this->assertEquals("muerta", $enana2->getSituacion());
    }

    public function testHeridaGrave() {
        #Se probará el efecto de una herida grave a una Enana con una situación de viva.
        #Se tendrá que probar que la vida es 0 y además que su situación es limbo
        $enana = new Enana("Fili", 20);
        $enana->heridaGrave();
        $this->assertEquals(0, $enana->getPuntosVida());
        $this->assertEquals("limbo", $enana->getSituacion());
    }
    
    public function testPocimaRevive() {
        #Se probará el efecto de administrar una pócima a una Enana muerta pero con una vida mayor que -10 y menor que 0
        #Se tendrá que probar que la vida es mayor que 0 y que su situación ha cambiado a viva
        $enana = new Enana("Gloin", -5);
        $enana->pocima();
        $this->assertGreaterThan(0, $enana->getPuntosVida());
        $this->assertEquals("viva", $enana->getSituacion());
    }

    public function testPocimaNoRevive() {
        #Se probará el efecto de administrar una pócima a una Enana en el libo
        #Se tendrá que probar que la vida y situación no ha cambiado
        $enana = new Enana("Bifur", 0);
        $situacionAntes = $enana->getSituacion();
        $puntosVidaAntes = $enana->getPuntosVida();
        $enana->pocima();
        $this->assertEquals($situacionAntes, $enana->getSituacion());
        $this->assertEquals($puntosVidaAntes, $enana->getPuntosVida());
    }

    public function testPocimaExtraLimbo() {
        #Se probará el efecto de administrar una pócima Extra a una Enana en el limbo.
        #Se tendrá que probar que la vida es 50 y la situación ha cambiado a viva.
        $enana = new Enana("Bombur", 0);
        $enana->pocimaExtra();
        $this->assertEquals(50, $enana->getPuntosVida());
        $this->assertEquals("viva", $enana->getSituacion());
    }
}
?>