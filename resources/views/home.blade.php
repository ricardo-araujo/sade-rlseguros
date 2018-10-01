@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <!-->

            <div style="margin-bottom: 15px;">
                <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="cn-tab" data-toggle="tab" href="#cn" role="tab" aria-controls="home" aria-selected="true">ComprasNet</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="bb-tab" data-toggle="tab" href="#bb" role="tab" aria-controls="profile" aria-selected="false">Banco do Brasil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="io-tab" data-toggle="tab" href="#io" role="tab" aria-controls="messages" aria-selected="false">Imprensa Oficial</a>
                    </li>
                </ul>
            </div>

            <div class="tab-content">
                <div class="tab-pane active" id="cn" role="tabpanel" aria-labelledby="cn-tab">
                    @include('licitacoes-cn-list')
                </div>
                <div class="tab-pane" id="bb" role="tabpanel" aria-labelledby="bb-tab">
                    @include('licitacoes-bb-list')
                </div>
                <div class="tab-pane" id="io" role="tabpanel" aria-labelledby="io-tab">
                    @include('licitacoes-io-list')
                </div>
            </div>

        </div>
    </div>
</div>

@include('modal-inclui-reserva-io')

@endsection
