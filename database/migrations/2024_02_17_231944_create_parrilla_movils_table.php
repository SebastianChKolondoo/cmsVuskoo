<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('WEB_3_TARIFAS_TELCO_MOVIL', function (Blueprint $table) {
            $table->id();
            $table->string('operadora');
            $table->string('estado');
            $table->string('landing_link');
            $table->string('permanencia');
            $table->string('nombre_tarifa');
            $table->string('parrilla_bloque_1');
            $table->string('parrilla_bloque_2');
            $table->string('parrilla_bloque_3');
            $table->string('parrilla_bloque_4');
            $table->string('meses_permanencia');
            $table->string('precio');
            $table->string('precio_final');
            $table->string('num_meses_promo');
            $table->string('porcentaje_descuento');
            $table->string('imagen_promo');
            $table->string('promocion');
            $table->string('texto_alternativo_promo');
            $table->string('GB');
            $table->string('llamadas_ilimitadas');
            $table->string('coste_llamadas_minuto');
            $table->string('coste_establecimiento_llamada');
            $table->string('num_minutos_gratis');
            $table->string('nombre_terminal_regalo');
            $table->string('destacada');
            $table->string('orden_parrilla_operadora');
            $table->string('fecha_publicacion');
            $table->string('fecha_expiracion');
            $table->string('fecha_registro');
            $table->string('moneda');
            $table->string('landingLead');
            $table->string('slug_tarifa');
            $table->string('pais');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parrilla_movils');
    }
};
