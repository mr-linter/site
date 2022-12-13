<div id="tester">
    <div class="container">
        <div class="row">
            <div class="col">
                <?php echo $__env->make('components/mr', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>

            <div class="col">
                <?php echo $__env->make('components/json_editor', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>

        <div class="d-grid gap-2" style="padding-top: 10px">
            <button class="btn btn-primary" type="button">Test</button>
        </div>
    </div>
</div>
<?php /**PATH /home/artem/PhpstormProjects/mr-linter-site/resources/views/components/tester.blade.php ENDPATH**/ ?>