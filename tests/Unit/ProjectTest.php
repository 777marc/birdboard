<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use SebastianBergmann\FileIterator\Factory;

class ProjectTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function it_has_a_path()
    {
        $project = Factory('App\Project')->create();

        $this->assertEquals('/projects/' . $project->id, $project->path());
    }
}
