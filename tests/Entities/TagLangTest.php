<?php

namespace WalkerChiu\MorphTag;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use WalkerChiu\MorphTag\Models\Entities\Tag;
use WalkerChiu\MorphTag\Models\Entities\TagLang;

class TagLangTest extends \Orchestra\Testbench\TestCase
{
    use RefreshDatabase;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->loadMigrationsFrom(__DIR__ .'/../migrations');
        $this->withFactories(__DIR__ .'/../../src/database/factories');
    }

    /**
     * To load your package service provider, override the getPackageProviders.
     *
     * @param \Illuminate\Foundation\Application  $app
     * @return Array
     */
    protected function getPackageProviders($app)
    {
        return [\WalkerChiu\Core\CoreServiceProvider::class,
                \WalkerChiu\MorphTag\MorphTagServiceProvider::class];
    }

    /**
     * Define environment setup.
     *
     * @param \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
    }

    /**
     * A basic functional test on TagLang.
     *
     * For WalkerChiu\Core\Models\Entities\Lang
     *     WalkerChiu\MorphTag\Models\Entities\TagLang
     *
     * @return void
     */
    public function testMorphTagLang()
    {
        // Config
        Config::set('wk-core.onoff.core-lang_core', 0);
        Config::set('wk-morph-tag.onoff.core-lang_core', 0);
        Config::set('wk-core.lang_log', 1);
        Config::set('wk-morph-tag.lang_log', 1);
        Config::set('wk-core.soft_delete', 1);
        Config::set('wk-morph-tag.soft_delete', 1);

        // Give
        $db_morph_1 = factory(Tag::class)->create();
        $db_morph_2 = factory(Tag::class)->create();
        $db_lang_1 = factory(TagLang::class)->create(['morph_id' => $db_morph_1->id, 'morph_type' => Tag::class, 'code' => 'en_us', 'key' => 'name', 'value' => 'Hello']);
        $db_lang_2 = factory(TagLang::class)->create(['morph_id' => $db_morph_1->id, 'morph_type' => Tag::class, 'code' => 'en_us', 'key' => 'description']);
        $db_lang_3 = factory(TagLang::class)->create(['morph_id' => $db_morph_1->id, 'morph_type' => Tag::class, 'code' => 'zh_tw', 'key' => 'description']);
        $db_lang_4 = factory(TagLang::class)->create(['morph_id' => $db_morph_1->id, 'morph_type' => Tag::class, 'code' => 'en_us', 'key' => 'name']);
        $db_lang_5 = factory(TagLang::class)->create(['morph_id' => $db_morph_2->id, 'morph_type' => Tag::class, 'code' => 'en_us', 'key' => 'name']);
        $db_lang_6 = factory(TagLang::class)->create(['morph_id' => $db_morph_2->id, 'morph_type' => Tag::class, 'code' => 'zh_tw', 'key' => 'description']);

        // Get records after creation
            // When
            $records = TagLang::all();
            // Then
            $this->assertCount(6, $records);

        // Get record's morph
            // When
            $record = TagLang::find($db_lang_1->id);
            // Then
            $this->assertNotNull($record);
            $this->assertInstanceOf(Tag::class, $record->morph);

        // Scope query on whereCode
            // When
            $records = TagLang::ofCode('en_us')
                              ->get();
            // Then
            $this->assertCount(4, $records);

        // Scope query on whereKey
            // When
            $records = TagLang::ofKey('name')
                              ->get();
            // Then
            $this->assertCount(3, $records);

        // Scope query on whereCodeAndKey
            // When
            $records = TagLang::ofCodeAndKey('en_us', 'name')
                              ->get();
            // Then
            $this->assertCount(3, $records);

        // Scope query on whereMatch
            // When
            $records = TagLang::ofMatch('en_us', 'name', 'Hello')
                              ->get();
            // Then
            $this->assertCount(1, $records);
            $this->assertTrue($records->contains('id', $db_lang_1->id));
    }

    /**
     * A basic functional test on TagLang.
     *
     * For WalkerChiu\Core\Models\Entities\LangTrait
     *     WalkerChiu\MorphTag\Models\Entities\TagLang
     *
     * @return void
     */
    public function testMorphTag()
    {
        // Config
        Config::set('wk-core.onoff.core-lang_core', 0);
        Config::set('wk-morph-tag.onoff.core-lang_core', 0);
        Config::set('wk-core.lang_log', 1);
        Config::set('wk-morph-tag.lang_log', 1);
        Config::set('wk-core.soft_delete', 1);
        Config::set('wk-morph-tag.soft_delete', 1);

        // Give
        $db_morph_1 = factory(Tag::class)->create();
        $db_morph_2 = factory(Tag::class)->create();
        $db_lang_1 = factory(TagLang::class)->create(['morph_id' => $db_morph_1->id, 'morph_type' => Tag::class, 'code' => 'en_us', 'key' => 'name', 'value' => 'Hello']);
        $db_lang_2 = factory(TagLang::class)->create(['morph_id' => $db_morph_1->id, 'morph_type' => Tag::class, 'code' => 'en_us', 'key' => 'description']);
        $db_lang_3 = factory(TagLang::class)->create(['morph_id' => $db_morph_1->id, 'morph_type' => Tag::class, 'code' => 'zh_tw', 'key' => 'description']);
        $db_lang_4 = factory(TagLang::class)->create(['morph_id' => $db_morph_1->id, 'morph_type' => Tag::class, 'code' => 'en_us', 'key' => 'name']);
        $db_lang_5 = factory(TagLang::class)->create(['morph_id' => $db_morph_2->id, 'morph_type' => Tag::class, 'code' => 'en_us', 'key' => 'name']);
        $db_lang_6 = factory(TagLang::class)->create(['morph_id' => $db_morph_2->id, 'morph_type' => Tag::class, 'code' => 'zh_tw', 'key' => 'description']);

        // Get lang of record
            // When
            $record_1 = Tag::find($db_morph_1->id);
            $lang_1   = TagLang::find($db_lang_1->id);
            $lang_4   = TagLang::find($db_lang_4->id);
            // Then
            $this->assertNotNull($record_1);
            $this->assertTrue(!$lang_1->is_current);
            $this->assertTrue($lang_4->is_current);
            $this->assertCount(4, $record_1->langs);
            $this->assertInstanceOf(TagLang::class, $record_1->findLang('en_us', 'name', 'entire'));
            $this->assertEquals($db_lang_4->id, $record_1->findLang('en_us', 'name', 'entire')->id);
            $this->assertEquals($db_lang_4->id, $record_1->findLangByKey('name', 'entire')->id);
            $this->assertEquals($db_lang_2->id, $record_1->findLangByKey('description', 'entire')->id);

        // Get lang's histories of record
            // When
            $histories_1 = $record_1->getHistories('en_us', 'name');
            $record_2 = Tag::find($db_morph_2->id);
            $histories_2 = $record_2->getHistories('en_us', 'name');
            // Then
            $this->assertCount(1, $histories_1);
            $this->assertCount(0, $histories_2);
    }
}
