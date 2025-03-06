<!-- Modal per modifica veicolo -->
<div class="modal fade" id="modal_create_vehicle" data-bs-backdrop="static" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" >Crea Veicolo</h1>
                <a type="button" class="" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times fs-3"></i></a>
            </div>
            <div class="modal-body">
                <form id="create_vehicle_form">
                    <div class="row">
                        <input type="hidden" name="client_id" value="{{ $client->id }}" />
                        <div class="col-lg-12 mb-3">
                            <div class="form-group">
                                <label class="form-label">Marca</label>
                                <input type="text" name="brand"  class="form-control form-control-solid" placeholder="Inserisci marca" />
                            </div>
                        </div>

                        <div class="col-lg-12 mb-3">
                            <div class="form-group">
                                <label class="form-label">Modello</label>
                                <input type="text" name="model" class="form-control form-control-solid" placeholder="Inserisci modello" />
                            </div>
                        </div>

                        <div class="col-lg-12 mb-3">
                            <div class="form-group">
                                <label class="form-label required">Targa</label>
                                <input type="text" name="license_plate" class="form-control form-control-solid" placeholder="Inserisci targa" />
                            </div>
                        </div>

                        <div class="col-lg-12 mb-3">
                            <div class="form-group">
                                <label class="form-label">Anno</label>
                                <input type="text" name="year" class="form-control form-control-solid year_picker" placeholder="Inserisci anno" />
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
                <button type="button" class="btn btn-primary" id="create_save_button">Salva modifiche</button>
            </div>
        </div>
    </div>
</div>

