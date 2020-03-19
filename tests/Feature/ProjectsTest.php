<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function only_an_authenticated_user_can_create_a_project()
    {
        $attributes = factory('App\Project')->raw(['owner_id' => null]);

        $this->post('/projects', $attributes)->assertRedirect('login');
    }


    /** @test */
    public function an_authenticated_user_can_create_a_project()
    {
        $this->actingAs(factory('App\User')->create());

        $attributes = factory('App\Project')->raw();

        $this->post('/projects', $attributes)->assertRedirect('/projects');

        //$this->assertDatabaseHas('projects', $attributes);

        //$this->get('/projects')->assertSee($attributes['title']);

    }
    
    /** @test */
    public function guest_can_not_view_a_project()
    {
        $this->post('/projects')->assertRedirect('login');
    }

    /** @test */
    // public function a_user_can_view_a_project()
    // {
    //     $this->actingAs(factory('App\User')->create());    

    //     $project = factory('App\Project')->create();
       
    //     $this->get($project->path())
    //          ->assertSee($project->title)
    //          ->assertSee($project->description);

    // }

    /** @test */    
    public function a_project_requires_a_title()
    {
        $this->actingAs(factory('App\User')->create());

        $attributes = factory('App\Project')->raw(['title' => '']);

        $this->post('/projects', $attributes)->assertSessionHasErrors('title');
    }

    /** @test */    
    public function a_project_requires_a_description()
    {
        $this->actingAs(factory('App\User')->create());

        $attributes = factory('App\Project')->raw(['description' => '']);

        $this->post('/projects', $attributes)->assertSessionHasErrors('description');
    }
    
    /** @test */    
    public function a_project_requires_an_owner()
    {
        $this->actingAs(factory('App\User')->create());

        $attributes = factory('App\Project')->raw(['owner_id' => null]);

        $this->post('/projects', $attributes)->assertSessionDoesntHaveErrors();
    }
}
