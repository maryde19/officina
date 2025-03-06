<!-- Modal per modifica cliente -->
<div class="modal fade" id="modal_edit_client" data-bs-backdrop="static" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Modifica Cliente</h1>
                <a type="button" class="" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times fs-3"></i></a>
            </div>
            <div class="modal-body">
                <form id="edit_client_form">
                    <input type="hidden" name="client_id" id="client_id" />
                    <div class="row">
                        <div class="col-lg-12 mb-3">
                            <div class="form-group">
                                <label class="form-label required">Nominativo</label>
                                <input type="text" name="name"  class="form-control form-control-solid" placeholder="Inserisci il cliente" />
                            </div>
                        </div>

                        <div class="col-lg-12 mb-3">
                            <div class="form-group">
                                <label class="form-label">Telefono</label>
                                <input type="text" name="phone"  class="form-control form-control-solid" placeholder="Inserisci il telefono" />
                            </div>
                        </div>

                        <div class="col-lg-12 mb-3">
                            <div class="form-group">
                                <label class="form-label">Email</label>
                                <input type="text" name="email" class="form-control form-control-solid" placeholder="Inserisci email" />
                            </div>
                        </div>

                        <div class="col-lg-12 mb-3">
                            <div class="form-group">
                                <label class="form-label">Indirizzo</label>
                                <input type="text" name="address" class="form-control form-control-solid" placeholder="Inserisci indirizzo" />
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
                <button type="button" class="btn btn-primary" id="edit_save_button">Salva modifiche</button>
            </div>
        </div>
    </div>
</div>

