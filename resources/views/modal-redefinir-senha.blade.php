<div class="modal fade" id="modal-redefinir-senha" tabindex="-1" role="dialog" aria-labelledby="modal-redefinir-senha" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Redefinir Senha</h5>
            </div>
            <div id="modal-body-senha" class="modal-body">

                <label class="sr-only" for="senha">Nova Senha</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="fa fa-key" aria-hidden="true"></i>
                        </div>
                    </div>
                    <input id="senha" name="senha" type="password" class="form-control" placeholder="Nova Senha" aria-label="Nova Senha" aria-describedby="button-senha" autocomplete="off" required>
                </div>

                <label class="sr-only" for="senha_confirmation">Confirmar Senha</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="fa fa-check" aria-hidden="true"></i>
                        </div>
                    </div>
                    <input id="senha_confirmation" name="senha_confirmation" type="password" class="form-control" placeholder="Confirmar Senha" aria-label="Confirmar Senha" aria-describedby="button-confirma-senha" autocomplete="off" required>
                </div>
            </div>

            <div class="modal-footer">
                <button id="btn-redefinir-senha-modal" type="button" class="btn btn-success">Gravar</button>
                <button id="btn-fecha-redefinir-senha-modal" type="button" class="btn btn-secondary">Fechar</button>
            </div>
        </div>
    </div>
</div>
