<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

class HomeControllerTest extends TestCase
{
    use RefreshDatabase;

    public function allows_anyone_to_see_list()
    {
        $response = $this->get(route('/'));
        $response->assertSuccessful();
    }

    function add_home_ajax() {
        $response = $this->action('POST', 'HomeController@storeOrUpdate', [
            'data' => ['id' => '', 'name' => 'teste', 'desc' => 'desc teste', 'date' => Carbon::now()]
        ]);
        $this->assertTrue($response->isOk());
        $this->assertViewHas('data', ['teste']);
    }

    function update_home_ajax(){
        $this->room = factory(App\Room::class)->create([
            'name' => 'teste',
            'description' => 'desc',
            'date' => Carbon::now()
        ]);

        $response = $this->action('POST', 'HomeController@storeOrUpdate', [
            'data' => ['id' => $this->room->id, 'name' => 'teste update', 'desc' => 'desc teste', 'date' => Carbon::now()]
        ]);

        $this->assertTrue($response->isOk());
        $this->assertViewHas('data', ['teste']);
    }

    function delete_home_ajax(){
        $this->room = factory(App\Room::class)->create([
            'name' => 'teste',
            'description' => 'desc',
            'date' => Carbon::now()
        ]);

        $response = $this->action('DELETE', 'HomeController@delete', [
            'data' => ['id' => $this->room->id]
        ]);

        $this->assertTrue($response->isOk());
    }
}
