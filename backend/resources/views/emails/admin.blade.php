@component('mail::message')
# Relatório de Vendas do Dia para Administrador

Aqui está o resumo das vendas do dia:

- **Total de Vendas:** {{ count($vendas) }}
- **Valor Total das Vendas:** R$ {{ number_format($valorTotal, 2, ',', '.') }}

Obrigado,<br>
{{ config('app.name') }}
@endcomponent
