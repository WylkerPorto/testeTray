@component('mail::message')
# Relatório de Vendas do Dia

Olá, {{ $vendas->first()->seller->name }}, <!-- Nome do vendedor -->

Aqui está o resumo das suas vendas do dia:

- **Total de Vendas:** {{ count($vendas) }}
- **Valor Total das Vendas:** R$ {{ number_format((float)$valorTotal, 2, ',', '.') }}
- **Total de Comissões:** R$ {{ number_format((float)$comissaoTotal, 2, ',', '.') }}

## Detalhes das Vendas

| Data da Venda | Valor da Venda | Comissão |
|:--------------|:---------------|:--------|
@foreach($vendas as $venda)
| {{ \Carbon\Carbon::parse($venda->sale_date)->format('d/m/Y') }} | R$ {{ number_format((float)$venda->value, 2, ',', '.') }} | R$ {{ number_format((float)($venda->value * 0.085), 2, ',', '.') }} |
@endforeach

Obrigado,<br>
{{ config('app.name') }}

@component('mail::footer')
Este é um e-mail automático. Por favor, não responda.
@endcomponent
@endcomponent
