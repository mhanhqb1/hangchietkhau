<div class="box box-primary box-search collapsed-box">
    <div class="box-header with-border">
        <h3 class="box-title"><?php echo __('LABEL_SEARCH') ?></h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
        </div>
    </div>
    <div class="box-body">
        <?php echo $this->SimpleForm->render($searchForm); ?>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="box box-result">
            <?php
                echo $this->SimpleTable->render($table);
                echo $this->Paginate->render($total, $limit);
            ?>
        </div>
    </div>
</div>
