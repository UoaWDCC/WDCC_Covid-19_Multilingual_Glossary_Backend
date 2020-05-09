<?php

namespace Tests\Feature;

use App\Language;
use App\Translation;
use App\Word;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WordTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testChinese()
    {
        $response = $this->get('/translations/病毒');

        $response
            ->assertStatus(200)
            ->assertJson([
                "ZH CN" => [
                    [
                        "id" => "1",
                        "name" => "病毒",
                        "language_name" => "ZH CN",
                        "translation_id" => "1"
                    ]
                ]
            ]);
    }

    public function testAccent()
    {
        $response = $this->get('/translations/bìngdú');

        $response
            ->assertStatus(200)
            ->assertJson([
                "pinyin" => [
                    [
                        "id" => "2",
                        "name" => "bìngdú",
                        "language_name" => "pinyin",
                        "translation_id" => "1"
                    ]
                ]
            ]);
    }

    // @todo testing the /translation endpoint

    // @todo test that two words with same languages are grouped together

    // @todo test that two words with same translation id but different languages are not grouped together

    // @todo test that when users search for non-exist words, empty result is returned

    public function setUp() : void
    {
        parent::setUp();

        // generate three languages
        factory(Language::class)->create([
            'id' => '1',
            'name' => 'EN English'
        ]);
        factory(Language::class)->create([
            'id' => '2',
            'name' => 'ZH CN'
        ]);
        factory(Language::class)->create([
            'id' => '3',
            'name' => 'pinyin'
        ]);

        // generate three translations
        factory(Translation::class)->create([
            'id' => '1',
            'name' => 'Virus'
        ]);

        factory(Translation::class)->create([
            'id' => '2',
            'name' => 'novel coronavirus'
        ]);

        factory(Translation::class)->create([
            'id' => '3',
            'name' => 'Covid-19'
        ]);

        // generate 5 words belonging
        factory(Word::class)->create([
            'name' => '病毒',
            'language_id' => '2',
            'translation_id' => '1'
        ]);

        factory(Word::class)->create([
            'name' => 'bìngdú',
            'language_id' => '3',
            'translation_id' => '1'
        ]);

        factory(Word::class)->create([
            'name' => 'novel coronavirus',
            'language_id' => '1',
            'translation_id' => '2'
        ]);

        factory(Word::class)->create([
            'name' => 'xīnxíng guānzhuàng bìngdú (xīnguān bìngdú)',
            'language_id' => '3',
            'translation_id' => '2'
        ]);

        factory(Word::class)->create([
            'name' => 'fèiyán',
            'language_id' => '3',
            'translation_id' => '3'
        ]);

    }
}
