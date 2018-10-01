<h2>Imprensa Oficial</h2>
@if($oportunidadesIO->isEmpty())
    <p> Não houve oportunidades para o portal Imprensa Oficial </p>
@else
    @foreach($oportunidadesIO as $oportunidade)
        <h4>{{ $oportunidade->nm_orgao}} </h4>
        <p> Licitação: {{ $oportunidade->nu_licitacao }} </p>
        <p> Pregão: {{ $oportunidade->nm_pregao }} </p>
        <p> Oportunidade capturada às {{ $oportunidade->created_at->format('H:i:s') }} </p>

        @if($oportunidade->reserva->isEmpty())
        <p> Não houve reserva para a oportunidade </p>
        @else
        <table style="border: 1px solid black; width: 50%; margin-left: auto; margin-right: auto;">
            <thead>
            <tr>
                <th colspan="4" style="text-align: center"> Detalhes da(s) Reserva(s) </th>
            </tr>
            <tr style="text-align: center">
                <th>Número</th>
                <th>Início de Upload</th>
                <th>Fim de Upload</th>
                <th>Concluído</th>
            </tr>
            </thead>
            <tbody>
            @foreach($oportunidade->reserva as $reserva)
                <tr style="text-align: center">
                    <td> {{ $reserva->nm_reserva }} </td>
                    <td> {{ ($reserva->dt_inicio_upload) ? $reserva->dt_inicio_upload->format('H:i:s') : '-' }} </td>
                    <td> {{ ($reserva->dt_fim_upload) ? $reserva->dt_fim_upload->format('H:i:s') : '-' }} </td>
                    <td> {{ ((bool) $reserva->was_uploaded) ? 'Sim' : 'Não'}} </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        @endif
        <hr style="color: #ced9e1">
    @endforeach
@endif
