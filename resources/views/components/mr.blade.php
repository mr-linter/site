<div id="merge-request">
    <div class="merge-request-title">
        <input type="text" name="title" value="Request Title"/>
    </div>

    <div class="merge-request-description">
        <input type="text" name="description" placeholder="Request Description" />
    </div>

    <div class="merge-request-tags">
        <div class="input-group input-group-sm">
            <span class="input-group-text" id="merge-request-source-branch">source branch</span>
            <input type="text" name="source_branch" class="form-control" value="dev" aria-label="dev" aria-describedby="merge-request-source-branch">

            <span class="input-group-text" id="merge-request-target-branch">target branch</span>
            <input type="text" name="target_branch" class="form-control" value="master" aria-label="dev" aria-describedby="merge-request-target-branch">
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

    <div class="merge-request-tags">
        <div class="row">
            <div class="col">
        <div class="form-check">
            <input class="form-check-input" name="has_conflicts" type="checkbox" value=true id="hasConflictsChecked" checked>
            <label class="form-check-label" for="hasConflictsChecked">
                Has Conflicts ?
            </label>
        </div>
            </div>

            <div class="col">
        <div class="input-group input-group-sm">
            <span class="input-group-text" id="merge-request-changed-files-count">Changed files count</span>
            <input type="number" name="changed_files_count" value="10" class="form-control" value="dev" aria-label="dev" aria-describedby="merge-request-changed-files-count">
        </div>
            </div>
        </div>
    </div>
</div>

<script>

</script>
