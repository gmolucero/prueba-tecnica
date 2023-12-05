<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?><?= $title ?><?= $this->endSection() ?>

<?= $this->section('main') ?>

<?= $this->include('incidents/_navbar') ?>

<div class="container">
    <div class="row">
        <div class="col-12 m-3">
            <h1><?= $title ?></h1>
        </div>
    </div>
    <?php if (isset($error_message)) : ?>
        <div class="row">
            <div class="col-12">
                <div class="alert alert-danger">
                    <?= $error_message ?>
                    <ul>
                        <?php foreach ($errors as $error) : ?>
                            <li><?= $error ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <?= form_open(current_url(), ['class' => 'form-control'], isset($hidden) ? $hidden : []) ?>
    <div class="row">
        <div class="col-12 mb-3">
            <?= form_label('Titulo', 'title') ?>
            <?= form_input(
                'title',
                isset($incident) ? $incident->title : '',
                [
                    'id' => 'title',
                    'class' => isset($errors->title) ? 'form-control is-invalid' : 'form-control'
                ]
            )
            ?>
            <?= isset($errors->title) ? "<div id='title-error' class='invalid-feedback'>" . $errors->title . '</div>' : '' ?>
        </div>
        <div class="col-12 col-md-6 mb-3">
            <?= form_label('Lugar incidente', 'location') ?>
            <?= form_input(
                'location',
                isset($incident) ? $incident->location : '',
                [
                    'id' => 'location',
                    'class' => isset($errors->location) ? 'form-control is-invalid' : 'form-control'
                ]
            )
            ?>
            <?= isset($errors->location) ? "<div id='location-error' class='invalid-feedback'>" . $errors->location . '</div>' : '' ?>
        </div>
        <div class="col-12 col-md-6 mb-3">
            <?= form_label('Fecha y hora del incidente', 'date') ?>
            <?= form_input(
                'date',
                isset($incident) ? $incident->date : '',
                [
                    'id' => 'date',
                    'class' => isset($errors->date) ? 'form-control is-invalid' : 'form-control'
                ],
                'datetime-local'
            )
            ?>
            <?= isset($errors->date) ? "<div id='date-error' class='invalid-feedback'>" . $errors->date . '</div>' : '' ?>
        </div>
        <?php if (isset($incident)) : ?>
            <div class="col-12 col-md-6 mb-3">
                <?= form_label('Estado', 'status') ?>
                <?= form_dropdown(
                    'status',
                    $statusList,
                    isset($incident) ? $incident->status : '',
                    [
                        'id' => 'status',
                        'class' => isset($errors->status) ? 'form-select is-invalid' : 'form-select'
                    ]
                ); ?>
                <?= isset($errors->status) ? "<div id='date-error' class='invalid-feedback'>" . $errors->status . '</div>' : '' ?>
            </div>
            <div class="col-12 col-md-6 mb-3">
                <?= form_label('Reportado por', 'user') ?>
                <?= form_input(
                    'user',
                    $incident->user,
                    [
                        'id' => 'user',
                        'class' => 'form-control',
                        'readonly' => true
                    ]
                ); ?>
                <?= isset($errors->date) ? "<div id='date-error' class='invalid-feedback'>" . $errors->date . '</div>' : '' ?>
            </div>
        <?php endif; ?>
        <div class="col-12 mb-3">
            <?= form_label('Descripcion', 'description') ?>
            <?= form_textarea(
                'description',
                isset($incident) ? $incident->description : '',
                [
                    'id' => 'description',
                    'class' => isset($errors->description) ? 'form-control is-invalid' : 'form-control'
                ]
            )
            ?>
            <?= isset($errors->description) ? "<div id='description-error' class='invalid-feedback'>" . $errors->description . '</div>' : '' ?>
        </div>
        <div class="col-12 mb-3">
            <?= form_submit('save', isset($incident->id) ? 'Actualizar' : 'Crear', ['class' => "btn btn-primary"]) ?>
        </div>
    </div>
    <?= form_close() ?>
</div>
<?= $this->endSection() ?>

<?= $this->section('pageScripts') ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/9a1374fb10.js" crossorigin="anonymous"></script>
<?= $this->endSection() ?>