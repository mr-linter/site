<div id="jsoneditor"></div>

<script>
    // create the editor
    const container = document.getElementById("jsoneditor")
    const options = {}
    const editor = new JSONEditor(container, options)

    // set json
    const initialJson = {
        "rules": {
            "@mr-linter/description_contains_links_of_any_domains": {
                "domains": ["vk.com"],
                "when": {
                    "labels": {
                        "contains": "Feature",
                        "countMin": 1000
                    }
                }
            },
            "@mr-linter/changed_files_limit": {
                "limit": 1,
                "when": {
                    "title": {
                        "starts": "[Feature] ",
                        "ends": "es",
                        "equals": "dd"
                    }
                }
            },
            "@mr-linter/jira/has_issue_link": {
                "domain": "jira.com",
                "projectCode": "MYPROJECT",
                "when": {
                    "labels1": {
                        "contains": "Feature"
                    },
                    "targetBranch": {
                        "ends": "er"
                    },
                    "changedFilesCount": {
                        ">=": 1
                    }
                }
            },
            "@mr-linter/description_not_empty": {
                "when": {
                    "targetBranch": {
                        "equals": "master"
                    }
                }
            }
        },
        "credentials": {
            "github_actions": "env(MR_LINTER_GITHUB_HTTP_TOKEN)"
        }
    }

    editor.set(initialJson)

    // get json
    const updatedJson = editor.get()
</script>
<?php /**PATH /home/artem/PhpstormProjects/mr-linter-site/resources/views/components/json_editor.blade.php ENDPATH**/ ?>