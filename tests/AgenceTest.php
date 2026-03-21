<?php

use PHPUnit\Framework\TestCase;
use App\Models\Agence;

class AgenceTest extends TestCase
{
    private Agence $model;

    protected function setUp(): void
    {
        require_once __DIR__ . '/../config/database.php';
        $this->model = new Agence();
    }

    public function testCreate(): void
    {
        $this->model->create('TestVille');

        $agences = $this->model->getAll();
        $noms = array_column($agences, 'nom');
        $this->assertContains('TestVille', $noms);

        foreach ($agences as $agence) {
            if ($agence['nom'] === 'TestVille') {
                $this->model->delete((int) $agence['id']);
            }
        }
    }

    public function testUpdate(): void
    {
        $this->model->create('VilleAvant');

        $agences = $this->model->getAll();
        $id = null;
        foreach ($agences as $agence) {
            if ($agence['nom'] === 'VilleAvant') {
                $id = (int) $agence['id'];
                break;
            }
        }

        $this->assertNotNull($id);

        $this->model->update($id, 'VilleApres');

        $agences = $this->model->getAll();
        $noms = array_column($agences, 'nom');
        $this->assertContains('VilleApres', $noms);
        $this->assertNotContains('VilleAvant', $noms);

        $this->model->delete($id);
    }

    public function testDelete(): void
    {
        $this->model->create('VilleASupprimer');

        $agences = $this->model->getAll();
        $id = null;
        foreach ($agences as $agence) {
            if ($agence['nom'] === 'VilleASupprimer') {
                $id = (int) $agence['id'];
                break;
            }
        }

        $this->assertNotNull($id);

        $this->model->delete($id);

        $agences = $this->model->getAll();
        $noms = array_column($agences, 'nom');
        $this->assertNotContains('VilleASupprimer', $noms);
    }
}
