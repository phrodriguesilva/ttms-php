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
        Schema::table('bookings', function (Blueprint $table) {
            // Informações da Corrida
            if (!Schema::hasColumn('bookings', 'lead_source')) {
                $table->string('lead_source')->nullable(); // Empresa/Lead de Origem
            }
            if (!Schema::hasColumn('bookings', 'service_type')) {
                $table->string('service_type')->nullable(); // Tipo de Serviço
            }
            if (!Schema::hasColumn('bookings', 'passengers_count')) {
                $table->integer('passengers_count')->default(1); // Quantidade de passageiros
            }
            if (!Schema::hasColumn('bookings', 'luggage_count')) {
                $table->integer('luggage_count')->default(0); // Quantidade de bagagens
            }
            
            // Informações do Cliente
            if (!Schema::hasColumn('bookings', 'client_first_name')) {
                $table->string('client_first_name')->nullable();
            }
            if (!Schema::hasColumn('bookings', 'client_last_name')) {
                $table->string('client_last_name')->nullable();
            }
            if (!Schema::hasColumn('bookings', 'client_email')) {
                $table->string('client_email')->nullable();
            }
            if (!Schema::hasColumn('bookings', 'client_alternative_email')) {
                $table->string('client_alternative_email')->nullable();
            }
            if (!Schema::hasColumn('bookings', 'client_phone')) {
                $table->string('client_phone')->nullable();
            }
            if (!Schema::hasColumn('bookings', 'client_work_phone')) {
                $table->string('client_work_phone')->nullable();
            }
            if (!Schema::hasColumn('bookings', 'client_other_phone')) {
                $table->string('client_other_phone')->nullable();
            }
            if (!Schema::hasColumn('bookings', 'account_status')) {
                $table->string('account_status')->default('inactive'); // Status da conta B.R.O.
            }
            if (!Schema::hasColumn('bookings', 'account_manager_id')) {
                $table->unsignedBigInteger('account_manager_id')->nullable(); // Gerente da Conta
            }
            if (!Schema::hasColumn('bookings', 'client_notes')) {
                $table->text('client_notes')->nullable(); // Notas do Cliente
            }
            if (!Schema::hasColumn('bookings', 'account_type')) {
                $table->enum('account_type', ['personal', 'corporate'])->default('personal'); // Tipo de Conta
            }
            
            // Locais
            if (!Schema::hasColumn('bookings', 'pickup_details')) {
                $table->text('pickup_details')->nullable(); // Detalhes do local de embarque
            }
            if (!Schema::hasColumn('bookings', 'dropoff_details')) {
                $table->text('dropoff_details')->nullable(); // Detalhes do local de desembarque
            }
            if (!Schema::hasColumn('bookings', 'stops')) {
                $table->text('stops')->nullable(); // Paradas intermediárias
            }
            if (!Schema::hasColumn('bookings', 'distance')) {
                $table->decimal('distance', 10, 2)->nullable(); // Distância total
            }
            
            // Notas
            if (!Schema::hasColumn('bookings', 'client_visible_notes')) {
                $table->text('client_visible_notes')->nullable(); // Notas visíveis ao cliente
            }
            if (!Schema::hasColumn('bookings', 'driver_notes')) {
                $table->text('driver_notes')->nullable(); // Notas do motorista
            }
            if (!Schema::hasColumn('bookings', 'internal_notes')) {
                $table->text('internal_notes')->nullable(); // Notas internas
            }
            
            // Taxas e Valores
            if (!Schema::hasColumn('bookings', 'rate_type')) {
                $table->enum('rate_type', ['hourly', 'fixed', 'distance'])->default('fixed'); // Tipo de Tarifa
            }
            if (!Schema::hasColumn('bookings', 'duration_hours')) {
                $table->integer('duration_hours')->default(0); // Duração em horas
            }
            if (!Schema::hasColumn('bookings', 'duration_minutes')) {
                $table->integer('duration_minutes')->default(0); // Duração em minutos
            }
            if (!Schema::hasColumn('bookings', 'hourly_rate')) {
                $table->decimal('hourly_rate', 10, 2)->nullable(); // Tarifa por hora
            }
            if (!Schema::hasColumn('bookings', 'base_rate')) {
                $table->decimal('base_rate', 10, 2)->default(0.00); // Valor base
            }
            if (!Schema::hasColumn('bookings', 'gratuity')) {
                $table->decimal('gratuity', 10, 2)->default(0.00); // Gorjeta
            }
            if (!Schema::hasColumn('bookings', 'fuel_surcharge')) {
                $table->decimal('fuel_surcharge', 10, 2)->default(0.00); // Taxa de combustível
            }
            if (!Schema::hasColumn('bookings', 'tax_amount')) {
                $table->decimal('tax_amount', 10, 2)->default(0.00); // Impostos
            }
            if (!Schema::hasColumn('bookings', 'discount_amount')) {
                $table->decimal('discount_amount', 10, 2)->default(0.00); // Desconto
            }
            if (!Schema::hasColumn('bookings', 'toll_amount')) {
                $table->decimal('toll_amount', 10, 2)->default(0.00); // Pedágios
            }
            if (!Schema::hasColumn('bookings', 'extra_seats')) {
                $table->integer('extra_seats')->default(0); // Quantidade de assentos extras
            }
            if (!Schema::hasColumn('bookings', 'extra_seats_cost')) {
                $table->decimal('extra_seats_cost', 10, 2)->default(0.00); // Custo dos assentos extras
            }
            if (!Schema::hasColumn('bookings', 'meet_and_greet')) {
                $table->boolean('meet_and_greet')->default(false); // Serviço de recepção
            }
            if (!Schema::hasColumn('bookings', 'meet_and_greet_cost')) {
                $table->decimal('meet_and_greet_cost', 10, 2)->default(0.00); // Custo do serviço de recepção
            }
            
            // Pagamento
            if (!Schema::hasColumn('bookings', 'deposit_amount')) {
                $table->decimal('deposit_amount', 10, 2)->default(0.00); // Valor do depósito
            }
            if (!Schema::hasColumn('bookings', 'credit_card_fee')) {
                $table->decimal('credit_card_fee', 10, 2)->default(0.00); // Taxa de cartão de crédito
            }
            if (!Schema::hasColumn('bookings', 'payment_due_date')) {
                $table->date('payment_due_date')->nullable(); // Data de vencimento
            }
            if (!Schema::hasColumn('bookings', 'amount_paid')) {
                $table->decimal('amount_paid', 10, 2)->default(0.00); // Total pago
            }
            if (!Schema::hasColumn('bookings', 'payment_method')) {
                $table->string('payment_method')->nullable(); // Método de pagamento
            }
            
            // Campos de controle
            if (!Schema::hasColumn('bookings', 'quote_number')) {
                $table->string('quote_number')->nullable(); // Número do orçamento
            }
            if (!Schema::hasColumn('bookings', 'quote_expires_at')) {
                $table->timestamp('quote_expires_at')->nullable(); // Data de expiração do orçamento
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $columns = [
                'lead_source',
                'service_type',
                'passengers_count',
                'luggage_count',
                'client_first_name',
                'client_last_name',
                'client_email',
                'client_alternative_email',
                'client_phone',
                'client_work_phone',
                'client_other_phone',
                'account_status',
                'account_manager_id',
                'client_notes',
                'account_type',
                'pickup_details',
                'dropoff_details',
                'stops',
                'distance',
                'client_visible_notes',
                'driver_notes',
                'internal_notes',
                'rate_type',
                'duration_hours',
                'duration_minutes',
                'hourly_rate',
                'base_rate',
                'gratuity',
                'fuel_surcharge',
                'tax_amount',
                'discount_amount',
                'toll_amount',
                'extra_seats',
                'extra_seats_cost',
                'meet_and_greet',
                'meet_and_greet_cost',
                'deposit_amount',
                'credit_card_fee',
                'payment_due_date',
                'amount_paid',
                'payment_method',
                'quote_number',
                'quote_expires_at'
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('bookings', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
