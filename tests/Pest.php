<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
*/

// O segredo está aqui: usamos 'uses' em vez de 'pest()->extend' (que é a sintaxe antiga)
// O RefreshDatabase aqui garante que seu Postgres de teste seja limpo em cada rodada.
uses(
    TestCase::class,
    RefreshDatabase::class
)->in('Feature');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions (OPCIONAL)
|--------------------------------------------------------------------------
| Se você quiser usar actingAs() sem importar no arquivo,
| o uses() acima já resolve 90% dos casos no Pest v2/v3.
*/
