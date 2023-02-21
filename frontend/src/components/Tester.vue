<template>
  <div id="tester">
    <div class="container">
      <div class="row" style="padding-bottom: 10px">

        <div class="col">
          <merge-request :merge_request="merge_request"></merge-request>
        </div>

        <div class="col">
          <config-editor :lint_config="lint_config"></config-editor>
        </div>
      </div>

      <lint-result v-if="lint_result" v-bind:result="lint_result"></lint-result>

      <div class="d-grid gap-2" style="padding-top: 10px">
        <button class="btn btn-primary" type="button" @click="lintRequest">Test</button>
      </div>
    </div>
  </div>
</template>

<script>
import MergeRequest from '../components/MergeRequest'
import LintResult from '../components/LintResult'
import ConfigEditor from "./ConfigEditor";
import axios from 'axios';

export default {
  components: {ConfigEditor, LintResult, MergeRequest},
  data: () => {
    return {
      merge_request: {
        title: 'Super Feature Request',
        description: '',
        changed_files_count: 10,
        has_conflicts: false,
        source_branch: 'dev',
        target_branch: 'master'
      },
      lint_config: {
        definition: "{\n" +
          "  \"rules\": {\n" +
          "    \"@mr-linter/description_contains_links_of_any_domains\": {\n" +
          "      \"domains\": [\"vk.com\"],\n" +
          "      \"when\": {\n" +
          "        \"labels\": {\n" +
          "          \"has\": \"Feature\",\n" +
          "          \"countMin\": 1000\n" +
          "        }\n" +
          "      }\n" +
          "    },\n" +
          "    \"@mr-linter/changed_files_limit\": {\n" +
          "      \"limit\": 1,\n" +
          "      \"when\": {\n" +
          "        \"title\": {\n" +
          "          \"starts\": \"[Feature] \",\n" +
          "          \"ends\": \"es\",\n" +
          "          \"equals\": \"dd\"\n" +
          "        }\n" +
          "      }\n" +
          "    },\n" +
          "    \"@mr-linter/jira/has_issue_link\": {\n" +
          "      \"domain\": \"jira.com\",\n" +
          "      \"projectCode\": \"MYPROJECT\",\n" +
          "      \"when\": {\n" +
          "        \"labels1\": {\n" +
          "          \"contains\": \"Feature\"\n" +
          "        },\n" +
          "        \"targetBranch\": {\n" +
          "          \"ends\": \"er\"\n" +
          "        },\n" +
          "        \"changedFilesCount\": {\n" +
          "          \">=\": 1\n" +
          "        }\n" +
          "      }\n" +
          "    },\n" +
          "    \"@mr-linter/description_not_empty\": {\n" +
          "      \"when\": {\n" +
          "        \"targetBranch\": {\n" +
          "          \"equals\": \"master\"\n" +
          "        }\n" +
          "      }\n" +
          "    }\n" +
          "  },\n" +
          "  \"credentials\": {\n" +
          "    \"github_actions\": \"env(MR_LINTER_GITHUB_HTTP_TOKEN)\"\n" +
          "  }\n" +
          "}",
      },
      lint_result: null,
    }
  },
  methods: {
    lintRequest() {
      axios.post('http://localhost:8000/api/linter/lint', {
        config: JSON.parse(this.lint_config.definition),
        mergeRequest: this.merge_request,
      })
        .then(response => this.lint_result = response.data);
    }
  }
}
</script>

<style scoped>
#tester {
  padding: 15px;
  background: #eee;
}
</style>
