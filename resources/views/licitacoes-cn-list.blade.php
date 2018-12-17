@if($licitacoesCN->isEmpty())
    <div class="alert alert-info text-center" role="alert">
        <strong>Não foram encontradas licitações no dia de hoje.</strong>
    </div>
@else
    <div id="accordion">
    @foreach($licitacoesCN as $licitacao)
        <div class="card" style="margin: 5px">
            <div class="card-header" id="licitacao-{{ $licitacao->id }}">
                <h5 class="mb-0">
                    <button class="btn btn-light" data-toggle="collapse" data-target="#collapse{{ $licitacao->id }}" aria-expanded="true" aria-controls="collapseOne">
                        <strong>{{ $licitacao->id }} - </strong>{{ $licitacao->nm_orgao }}
                    </button>
                    @if($licitacao->nm_anexo_principal)
                    <a href="{{ route('download-cn', [$licitacao]) }}" class="btn btn-outline-dark" style="float: right" title="Clique para baixar os arquivos da oportunidade. (Disponibilizado às {{$licitacao->dt_registro_anexo->format('H:i:s')}})" download>
                        <strong> Download </strong>
                    </a>
                    @endif
                </h5>
            </div>
            @if($loop->first)
            <div id="collapse{{ $licitacao->id }}" class="collapse show" aria-labelledby="licitacao-{{ $licitacao->id }}" data-parent="#accordion">
            @else
            <div id="collapse{{ $licitacao->id }}" class="collapse" aria-labelledby="licitacao-{{ $licitacao->id }}" data-parent="#accordion">
            @endif
                <div class="card-body">
                    <table>
                        <tbody>
                            <tr>
                                <td style="padding: 0.5em;"><strong>UASG:</strong> {{ $licitacao->nu_uasg }}</td>
                            </tr>
                            <tr>
                                <td style="padding: 0.5em;"><strong>Pregão:</strong> {{ $licitacao->nm_pregao }}</td>
                            </tr>
                            <tr>
                                <td style="padding: 0.5em;"><strong>Modalidade:</strong> {{ $licitacao->nm_modalidade }}</td>
                            </tr>
                            <tr>
                                <td style="padding: 0.5em;"><strong>Objeto:</strong> {{ $licitacao->txt_objeto }}</td>
                            </tr>
                            <tr>
                                <td style="padding: 0.5em;"><strong>Abertura de Proposta:</strong> {{ $licitacao->dt_abertura_proposta->format('d/m/Y H:i:s') }}</td>
                            </tr>
                            <tr>
                                <td style="padding: 0.5em;">
                                    <strong>Reserva:</strong>
                                    <div id="div-reserva-{{ $licitacao->id }}" class="d-inline">
                                        @if($licitacao->reserva->isEmpty())
                                        Nenhuma reserva para a oportunidade.
                                        @else
                                            @foreach($licitacao->reserva as $reserva)
                                            <button id="btn-reserva-{{ $reserva->nm_reserva }}" type="button" class="btn btn-outline-primary btn-sm btn-reserva" title="Clique na reserva para excluí-la">{{ $reserva->nm_reserva }}</button>
                                            @endforeach
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <hr>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="input-group mb-3" style="width: 300px;">
                                        <input id="input-reserva-{{ $licitacao->id }}" name="input-reserva-{{ $licitacao->id }}" type="number" class="form-control" placeholder="Número da Reserva" aria-label="Número da Reserva">
                                        <div class="input-group-append">
                                            <button type="button" id="btn-cadastro-{{ $licitacao->id }}" class="btn btn-primary btn-cadastro"> Cadastrar </button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endforeach
    </div>
@endif
