<!-- Modal per modifica veicolo -->
<div class="modal fade" id="modal_create_service" data-bs-backdrop="static" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" >Crea Intervento</h1>
                <a type="button" class="" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times fs-3"></i></a>
            </div>
            <div class="modal-body">
                <form id="create_service_form">
                    <div class="row">
                        <div class="col-lg-12 mb-3">
                            <div class="form-group">
                                <label class="form-label required">Veicolo</label>
                                <select name="vehicle_id" id="select_vehicle_id" class="form-control form-control-solid">

                                </select>
                            </div>
                        </div>

                        <div class="col-lg-12 mb-3">
                            <div class="form-group">
                                <label class="form-label required">Descrizione</label>
                                <input type="text" name="description"  class="form-control form-control-solid" placeholder="Inserisci descrizione" />
                            </div>
                        </div>

                        <div class="col-lg-12 mb-3">
                            <div class="form-group">
                                <label class="form-label required">Costo</label>
                                <input type="number" step="0.01" name="cost" class="form-control form-control-solid" placeholder="Inserisci costo" />
                            </div>
                        </div>

                        <div class="col-lg-12 mb-3">
                            <div class="form-group">
                                <label class="form-label required">Data</label>
                                <input type="text" name="date" class="form-control form-control-solid date_picker" placeholder="Inserisci data" autocomplete="off" readonly />
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
                <button type="button" class="btn btn-primary" id="create_service_save_button">Salva modifiche</button>
            </div>
        </div>
    </div>
</div>

