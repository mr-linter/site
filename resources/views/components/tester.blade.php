<div id="tester">
    <div class="container">
        <form id="merge-request-tester-form">
            <div class="row">
                <div class="col">
                    @include('components/mr')
                </div>

                <div class="col">
                    @include('components/json_editor')
                </div>
            </div>

            <div class="d-grid gap-2" style="padding-top: 10px">
                <button class="btn btn-primary" type="button" onclick="lintRequest(); return false;">Test</button>
            </div>
        </form>
    </div>
</div>

<script>
    function lintRequest() {
        // ...

        $.ajax({
            type: "POST",
            url: "/api/linter/lint",
            data: {
                "mergeRequest": getFormData($("#merge-request-tester-form")),
                "config": editor.get(),
            },
            dataType: "json",
            encode: true,
        }).done(function (data) {
            console.log(data);

            if (!data.success) {
                if (data.errors.name) {
                    $("#name-group").addClass("has-error");
                    $("#name-group").append(
                        '<div class="help-block">' + data.errors.name + "</div>"
                    );
                }

                if (data.errors.email) {
                    $("#email-group").addClass("has-error");
                    $("#email-group").append(
                        '<div class="help-block">' + data.errors.email + "</div>"
                    );
                }

                if (data.errors.superheroAlias) {
                    $("#superhero-group").addClass("has-error");
                    $("#superhero-group").append(
                        '<div class="help-block">' + data.errors.superheroAlias + "</div>"
                    );
                }
            } else {
                $("form").html(
                    '<div class="alert alert-success">' + data.message + "</div>"
                );
            }
        });
    }

    function getFormData($form){
        var unindexed_array = $form.serializeArray();
        var indexed_array = {};

        $.map(unindexed_array, function(n, i){
            let val = n['value']

            if (val === 'true') {
                val = true;
            }

            indexed_array[n['name']] = val;
        });

        return indexed_array;
    }
</script>
