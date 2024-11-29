<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class BookingRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'client_id' => 'required|exists:clients,id',
            'vehicle_id' => 'required|exists:vehicles,id',
            'driver_id' => 'required|exists:drivers,id',
            'service_type' => 'required|in:transfer,daily,event,tour',
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'pickup_location' => 'required|string|max:255',
            'dropoff_location' => 'required|string|max:255',
            'passenger_count' => 'required|integer|min:1',
            'total_amount' => 'required|numeric|min:0',
            'payment_method' => 'required|in:credit_card,debit_card,cash,bank_transfer,pix',
            'status' => 'sometimes|required|in:pending,confirmed,in_progress,completed,cancelled',
            'notes' => 'nullable|string',
            'lead_source' => 'required|in:website,phone,email,referral,other',
        ];
    }

    public function messages()
    {
        return [
            'client_id.required' => 'O cliente é obrigatório',
            'client_id.exists' => 'Cliente inválido',
            'vehicle_id.required' => 'O veículo é obrigatório',
            'vehicle_id.exists' => 'Veículo inválido',
            'driver_id.required' => 'O motorista é obrigatório',
            'driver_id.exists' => 'Motorista inválido',
            'service_type.required' => 'O tipo de serviço é obrigatório',
            'service_type.in' => 'Tipo de serviço inválido',
            'start_date.required' => 'A data de início é obrigatória',
            'start_date.date' => 'Data de início inválida',
            'start_date.after_or_equal' => 'A data de início deve ser hoje ou uma data futura',
            'end_date.required' => 'A data de término é obrigatória',
            'end_date.date' => 'Data de término inválida',
            'end_date.after_or_equal' => 'A data de término deve ser igual ou posterior à data de início',
            'pickup_location.required' => 'O local de partida é obrigatório',
            'dropoff_location.required' => 'O local de destino é obrigatório',
            'passenger_count.required' => 'O número de passageiros é obrigatório',
            'passenger_count.integer' => 'O número de passageiros deve ser um número inteiro',
            'passenger_count.min' => 'O número de passageiros deve ser pelo menos 1',
            'total_amount.required' => 'O valor total é obrigatório',
            'total_amount.numeric' => 'O valor total deve ser um número',
            'total_amount.min' => 'O valor total deve ser maior que zero',
            'payment_method.required' => 'O método de pagamento é obrigatório',
            'payment_method.in' => 'Método de pagamento inválido',
            'status.in' => 'Status inválido',
            'lead_source.required' => 'A origem do lead é obrigatória',
            'lead_source.in' => 'Origem do lead inválida',
        ];
    }

    protected function prepareForValidation()
    {
        if ($this->has('start_date')) {
            $this->merge([
                'start_date' => Carbon::parse($this->start_date)->format('Y-m-d H:i:s'),
            ]);
        }

        if ($this->has('end_date')) {
            $this->merge([
                'end_date' => Carbon::parse($this->end_date)->format('Y-m-d H:i:s'),
            ]);
        }
    }
}
