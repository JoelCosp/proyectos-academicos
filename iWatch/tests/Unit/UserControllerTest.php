<?php

namespace Tests\Unit;

use Tests\TestCase;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserControllerTest extends TestCase
{
    /**
     * A basic unit test example.
     */

    use RefreshDatabase;

    public function test_example(): void
    {
        $this->assertTrue(true);
    }

    public function it_updates_user_profile()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $newUserData = [
            'name' => 'John',
            'email' => 'john@example.com',
            'apellido' => 'Doe',
            'phone' => '123456789'
        ];

        $response = $this->put(route('user.update'), $newUserData);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => $newUserData['name'],
            'email' => $newUserData['email'],
            'apellido' => $newUserData['apellido'],
            'phone' => $newUserData['phone']
        ]);

        $response->assertStatus(200);

        $response->assertJson(['message' => 'Perfil actualizado correctamente']);
    }

    public function it_stores_a_new_user()
    {
        // Simulamos un usuario autenticado
        $this->actingAs(User::factory()->create());

        // Datos de prueba para crear un nuevo usuario
        $userData = [
            'name' => 'John',
            'apellido' => 'Doe',
            'email' => 'john@example.com',
            'password' => 'password123',
            // 'role_id' => Role::factory()->create()->id,
            'phone' => '123456789',
            // Agrega más campos si es necesario para representar tus datos de entrada
        ];

        // Simulamos la carga de un archivo de imagen de perfil
        Storage::fake('public');
        $file = UploadedFile::fake()->image('profile.jpg');

        // Hacemos una solicitud al método 'store' del controlador UserController
        $response = $this->post(route('user.store'), $userData + ['profile_image' => $file]);

        // Verificamos que el usuario se haya almacenado correctamente en la base de datos
        $this->assertDatabaseHas('users', [
            'name' => $userData['name'],
            'apellido' => $userData['apellido'],
            'email' => $userData['email'],
            'phone' => $userData['phone'],
            // Agrega más verificaciones según la estructura de tu base de datos
        ]);

        // Verificamos que el usuario tenga asignado el rol adecuado
        $this->assertDatabaseHas('role_user', [
            'user_id' => User::where('email', $userData['email'])->first()->id,
            'role_id' => $userData['role_id'],
        ]);

        // Verificamos que se haya almacenado la imagen de perfil correctamente
        Storage::disk('public')->assertExists('images2/profile/' . $file->hashName());

        // Verificamos que la respuesta sea exitosa
        $response->assertStatus(200);

        // Verificamos que la respuesta contenga los datos del usuario creado
        $response->assertJson([
            'name' => $userData['name'],
            'apellido' => $userData['apellido'],
            'email' => $userData['email'],
            'phone' => $userData['phone'],
            // Agrega más campos si es necesario según la respuesta esperada
        ]);
    }
}
