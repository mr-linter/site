<div id="merge-request">
    <div class="merge-request-title">
        <input type="text" name="merge_request[title]" value="Request Title"/>
    </div>

    <div class="merge-request-description">
        <input type="text" name="merge_request[description]" placeholder="Request Description" />
    </div>

    <div class="merge-request-tags">
        <div class="input-group input-group-sm">
            <span class="input-group-text" id="merge-request-source-branch">source branch</span>
            <input type="text" name="merge_request[sourceBranch]" class="form-control" placeholder="dev" aria-label="dev" aria-describedby="merge-request-source-branch">

            <span class="input-group-text" id="merge-request-target-branch">target branch</span>
            <input type="text" name="merge_request[targetBranch]" class="form-control" placeholder="master" aria-label="dev" aria-describedby="merge-request-target-branch">
        </div>
    </div>

    <div class="merge-request-tags">
        <button type="button" class="btn btn-sm btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            Tags
        </button>

        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
        </ul>
    </div>
</div>

<script>

</script>
<?php /**PATH /home/artem/PhpstormProjects/mr-linter-site/resources/views/components/mr.blade.php ENDPATH**/ ?>