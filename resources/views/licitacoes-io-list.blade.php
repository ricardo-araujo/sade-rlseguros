@if($licitacoesIO->isEmpty())
    <div class="alert alert-info text-center" role="alert">
        <strong>Não foram encontradas licitações no dia de hoje.</strong>
    </div>
@else
    <div id="accordion-io">
        @foreach($licitacoesIO as $licitacao)
            <div class="card" style="margin: 5px">
            <div class="card-header" id="licitacao-io-{{ $licitacao->id }}">
                <h5 class="mb-0">
                    <button class="btn btn-light" data-toggle="collapse" data-target="#collapse-io-{{ $licitacao->id }}" aria-expanded="true" aria-controls="collapseOne">
                        <strong>{{ $licitacao->id }} - </strong>{{ $licitacao->nm_orgao }}
                    </button>
                    @if($licitacao->nm_link_anexo)
                        <a href="{{ $licitacao->nm_link_anexo }}" class="btn btn-outline-dark" style="float: right" title="Clique para baixar os arquivos da oportunidade." download>
                            <strong> Download </strong>
                        </a>
                    @endif
                </h5>
            </div>
            @if($loop->first)
            <div id="collapse-io-{{ $licitacao->id }}" class="collapse show" aria-labelledby="licitacao-io-{{ $licitacao->id }}" data-parent="#accordion-io">
            @else
            <div id="collapse-io-{{ $licitacao->id }}" class="collapse" aria-labelledby="licitacao-io-{{ $licitacao->id }}" data-parent="#accordion-io">
            @endif
                <div class="card-body">
                    <table>
                        <tbody>
                            <tr>
                                <td style="padding: 0.5em;"><strong>Licitação:</strong> {{ $licitacao->nu_licitacao }}</td>
                            </tr>
                            <tr>
                                <td style="padding: 0.5em;"><strong>Objeto:</strong> {{ $licitacao->txt_objeto }}</td>
                            </tr>
                            <tr>
                                <td style="padding: 0.5em;"><strong>Edital:</strong> {{ $licitacao->nm_pregao }}</td>
                            </tr>
                            <tr>
                                <td style="padding: 0.5em;"><strong>Processo:</strong> {{ $licitacao->nm_processo }}</td>
                            </tr>
                            <tr>
                                <td style="padding: 0.5em;"><strong>Publicação:</strong> {{ $licitacao->dt_publicacao->format('d/m/Y H:i:s') }}</td>
                            </tr>
                            <tr>
                                <td style="padding: 0.5em;"><strong>Abertura:</strong> {{ $licitacao->dt_disputa->format('d/m/Y H:i:s') }}</td>
                            </tr>
                            <tr>
                                <td style="padding: 0.5em;">
                                    <strong>Reserva:</strong>
                                    <div id="div-reserva-{{ $licitacao->id }}" class="d-inline">
                                        @if($licitacao->reserva->isEmpty())
                                            Nenhuma Reserva para a oportunidade.
                                        @else
                                            @foreach($licitacao->reserva as $reserva)
                                                <span class="border border-primary rounded text-primary" style="padding: .35rem .5rem; font-size: .7875rem; line-height: 1.5; border-radius: .2rem;">{{ $reserva->nm_reserva }}</span>
                                            @endforeach
                                        @endif
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
