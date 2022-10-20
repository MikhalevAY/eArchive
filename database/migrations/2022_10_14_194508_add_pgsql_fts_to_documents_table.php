<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE documents ADD COLUMN text_idx TSVECTOR");
        DB::statement("UPDATE documents SET text_idx = to_tsvector('russian', text)");
        DB::statement("CREATE INDEX text_index ON documents USING GIN(text_idx)");
        DB::statement(
            "CREATE TRIGGER text_trigger
            BEFORE INSERT OR UPDATE ON documents
            FOR EACH ROW EXECUTE PROCEDURE tsvector_update_trigger('text_idx', 'pg_catalog.russian', 'text')"
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP TRIGGER IF EXISTS text_trigger ON documents");
        DB::statement("DROP INDEX IF EXISTS text_index");
        DB::statement("ALTER TABLE documents DROP COLUMN text_idx");
    }
};
