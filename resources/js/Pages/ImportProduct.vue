<template>
  <div class="container" style="margin-top: 50px">
    <div class="text-center">
      <h4>Import Product</h4>
      <br />
      <div style="max-width: 500px; margin: 0 auto">
        <div v-if="success" class="alert alert-success" role="alert">
          {{ success }}
        </div>
        <div v-if="error" class="alert alert-danger" role="alert">
          {{ error }}
        </div>
        <form @submit="submitForm" enctype="multipart/form-data">
          <div class="input-group">
            <div class="custom-file">
              <input
                type="file"
                name="filename"
                class="custom-file-input"
                id="inputFileUpload"
                v-on:change="onFileChange"
              />
              <label class="custom-file-label" for="inputFileUpload"
                >Choose file</label
              >
            </div>
            <div class="input-group-append">
              <input type="submit" class="btn btn-primary" value="Upload" />
            </div>
          </div>
          <br />
          <p class="text-danger font-weight-bold" v-if="filename">
            {{ filename }}
          </p>
        </form>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  mounted() {
    //console.log("Component successfully mounted.");
  },
  data() {
    return {
      filename: false,
      file: null,
      success: false,
      error:false,
    };
  },
  methods: {
    onFileChange(e) {
      this.filename = "Selected File: " + e.target.files[0].name;
      this.file = e.target.files[0];
    },
    submitForm(e) {
      e.preventDefault();
      let currentObj = this;
      const config = {
        headers: {
          "content-type": "Content-Encoding: UTF-8",
        },
      };
      // form data
      let formData = new FormData();
      formData.append("file", this.file);
      // send upload request
      this.$axios
        .get("/sanctum/csrf-cookie")
        .then((response) => {
          this.$axios
            .post("/api/products/import", formData, config)
            .then(function (response) {
              currentObj.success = response.data.success;
              currentObj.error = response.data.error;
              currentObj.filename = "";
       
            })
            .catch(function (error) {
              currentObj.output = error;
            });
        });
    },

  },
};
</script>