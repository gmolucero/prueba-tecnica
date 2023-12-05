<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?>Incidencias<?= $this->endSection() ?>

<?= $this->section('main') ?>

<?= $this->include('incidents/_navbar') ?>

<div class="container">
    <div class="row">
        <div class="col-12 my-3">
            <h1 class="mb-4">Incidencias</h1>
        </div>
        <div class="col-12 mb-3 text-end">
            <a href="<?= url_to('incidents.create') ?>" class="btn btn-primary">Nueva Incidencia</a>
        </div>
        <div class="col-12 my-3">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Estado</th>
                        <th>Titulo</th>
                        <th>Fecha reporte</th>
                        <th class="text-nowrap">Reportado por</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($incidents)) : ?>
                        <tr>
                            <td colspan="8">
                                <div class="alert alert-danger text-center">No hay incidencias</div>
                            </td>
                        </tr>
                    <?php else : ?>
                        <?php foreach ($incidents as $incident) : ?>
                            <tr>
                                <td><?= $incident->id ?></td>
                                <td><?= $incident->status ?></td>
                                <td><?= $incident->title ?></td>
                                <td><?= $incident->date ?></td>
                                <td><?= $incident->user ?></td>
                                <td class="text-nowrap col-1">
                                    <a href=" <?= url_to('incidents.detail', $incident->id) ?>" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Ver mas">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href=" <?= url_to('incidents.edit', $incident->id) ?>" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?= url_to('incidents.delete', $incident->id) ?>" class="deleteBtn btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Eliminar">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                    <?= form_close() ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- delete confirmation modal  -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Eliminar Incidente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro que quieres eliminar este incidente?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="deleteForm" action="" method="post">
                    <?= csrf_field() ?>
                    <button type="submit" id="deleteBtn" class="btn btn-danger">Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>


<?= $this->endSection() ?>

<?= $this->section('pageScripts') ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/9a1374fb10.js" crossorigin="anonymous"></script>
<script>
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    const myModal = new bootstrap.Modal('#deleteModal', {})

    document.querySelectorAll('.deleteBtn').forEach(function(element) {
        element.addEventListener('click', function(e) {
            e.preventDefault();
            const url = this.getAttribute('href');
            deleteForm.setAttribute('action', url);
            myModal.show();
        });
    });
</script>
<?= $this->endSection() ?>