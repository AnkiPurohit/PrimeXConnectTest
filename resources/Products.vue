<template>
  <div>
    <h4 class="mb-3">Product List</h4>
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-md-12">
            <b-button @click="newProductModal = !newProductModal" variant="link"
              >Add New Products</b-button
            >
          </div>
        </div>
        <!-- Modal -->
        <b-modal
          id="newProductModal"
          ref="modal"
          v-bind:title="this.editMode ? 'Update Product' : 'Add new Product'"
          v-model="newProductModal"
          no-close-on-backdrop
          no-close-on-esc
          hide-header-close
        >
          <div class="form-group">
            <label for="productCode">Product Code <span>*</span></label>
            <input
              type="text"
              class="form-control"
              id="code"
              placeholder="Enter Product Code"
              v-model="product.code"
            /><br />
            <b-alert show v-if="validationError.code" variant="danger">{{
              validationError.code
            }}</b-alert>
          </div>
          <div class="form-group">
            <label for="productName">Product Name <span>*</span></label>
            <input
              type="text"
              class="form-control"
              id="name"
              placeholder="Enter Product Name"
              v-model="product.name"
            /><br />
            <b-alert show v-if="validationError.name" variant="danger">{{
              validationError.name
            }}</b-alert>
          </div>
          <div class="form-group">
            <label for="productDescription">Description</label>
            <textarea
              class="form-control"
              id="description"
              placeholder="Enter Product Description"
              v-model="product.description"
            />
          </div>
          <template #modal-footer>
            <b-button
              v-if="!editMode"
              size="sm"
              variant="success"
              @click="saveProduct()"
            >
              Save
            </b-button>
            <b-button
              v-if="editMode"
              size="sm"
              variant="success"
              @click="updateProduct()"
            >
              Update
            </b-button>
            <b-button
              size="sm"
              variant="danger"
              @click="closeAndResetNewProduct()"
            >
              Cancel
            </b-button>
            <!-- Button with custom close trigger value -->
          </template>
        </b-modal>

        <!-- Modal for add stock on hand-->
        <b-modal
          id="newStockAddModal"
          ref="modal"
          title="Add Stock On-Hand"
          v-model="newStockAddModal"
          no-close-on-backdrop
          no-close-on-esc
          hide-header-close
        >
          <div class="form-group">
            <label for="productCode">Stock On Hand <span>*</span></label>
            <input
              type="text"
              class="form-control"
              id="on_hand"
              placeholder="Enter Stock On Hand"
              v-model="stock.on_hand"
            /><br />
            <b-alert show v-if="validationError.on_hand" variant="danger">{{
              validationError.on_hand
            }}</b-alert>
          </div>
          <div class="form-group">
            <label for="productCode">Stock Taken </label>
            <input
              type="text"
              class="form-control"
              id="taken"
              placeholder="Enter Stock Taken"
              v-model="stock.taken"
            /><br />
            <b-alert show v-if="validationError.taken" variant="danger">{{
              validationError.taken
            }}</b-alert>
          </div>
          <template #modal-footer>
            <b-button size="sm" variant="success" @click="saveStockOnHand()">
              Save
            </b-button>

            <b-button
              size="sm"
              variant="danger"
              @click="closeAndResetStockOnHand()"
            >
              Cancel
            </b-button>
            <!-- Button with custom close trigger value -->
          </template>
        </b-modal>
        <!-- <div class="row mt-2">
          <div class="col-md-4">
            <div class="">
              <div class="">
                <label>Select Date</label>
                <ejs-daterangepicker
                  id="daterangepicker"
                  :separator="seperate"
                  :startDate="startVal"
                  :endDate="endVal"
                  :placeholder="waterMark"
                  v-model="selectedDate"
                  v-bind:value="selectedDatebind"
                ></ejs-daterangepicker>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="">
              <div class="">
                <label>Select Customer</label>
                <ejs-dropdownlist
                  id="customer"
                  v-model="filterCustomer"
                  :dataSource="customers"
                  :fields="customerFields"
                ></ejs-dropdownlist>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="">
              <div class="">
                <label>Select Sales Person</label>
                <ejs-dropdownlist
                  id="sales_person"
                  v-model="filterSalesPerson"
                  :dataSource="employees"
                  :fields="salesPersonFields"
                ></ejs-dropdownlist>
              </div>
            </div>
          </div>
          <div class="col-md-2">
            <br />
            <a
              href="#"
              @click="loadSales"
              class="btn btn-primary stretched-link"
              >Apply</a
            >
          </div>
        </div> -->
        <div class="row"></div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <vuetable
          ref="vuetable"
          api-url="/api/products"
          pagination-path=""
          :css="css.table"
          :per-page="perPage"
          :fields="fields"
          @vuetable:pagination-data="onPaginationData"
        >
          <div slot="actions" slot-scope="props">
            <button
              class=""
              @click="onActionClicked('add-stock', props.rowData)"
            >
              <b-icon icon="plus" aria-hidden="true"></b-icon>
            </button>
            <button
              class=""
              @click="onActionClicked('edit-item', props.rowData)"
            >
              <b-icon icon="pencil-square" aria-hidden="true"></b-icon>
            </button>
            <button
              class=""
              @click="onActionClicked('delete-item', props.rowData)"
            >
              <b-icon icon="trash-fill" aria-hidden="true"></b-icon>
            </button>
          </div>
        </vuetable>
        <div style="margin-top: 10px">
          <vuetable-pagination
            ref="pagination"
            :css="css.pagination"
            class="pull-right"
            @vuetable-pagination:change-page="onChangePage"
          ></vuetable-pagination>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import Vuetable from "vuetable-2";
import VuetablePagination from "../components/VuetablePaginationBootstrap4.vue";
import VuetableFieldHandle from "vuetable-2/src/components/VuetableFieldHandle.vue";
import CssConfig from "../VuetableBootstrap4Config.js";

export default {
  components: {
    Vuetable,
    VuetablePagination,
    VuetableFieldHandle,
  },

  data() {
    return {
      newProductModal: false,
      newStockAddModal: false,
      editMode: false,
      stock: {
        on_hand: null,
        taken: null,
      },
      product: {
        code: null,
        name: null,
        description: null,
      },
      validationError: {
        code: null,
        name: null,
        description: null,
      },
      css: CssConfig,
      fields: [
        {
          name: "name",
          title: '<span class="orange glyphicon glyphicon-user"></span>Name',
          sortField: "name",
        },
        {
          name: "code",
          sortField: "code",
        },
        {
          name: "stockOnHand",
          title: "Stock On Hand",
          sortField: "stockOnHand",
        },
        "description",
        "actions",
      ],
      perPage: 10,
      data: [],
    };
  },

  watch: {
    data(newVal, oldVal) {
      this.$refs.vuetable.refresh();
    },
  },

  mounted() {
    /// axios.get("/api/productList").then((response) => {
    //   this.data = response.data;
    // });
    //  this.getProductData();
  },

  methods: {
    getProductData: function () {
      this.$axios
        .get("/sanctum/csrf-cookie")
        .then((response) => {
          this.$axios
            .get("/api/products")
            .then((response) => {
              console.log("response came");
              console.log(response);
              this.data = response.data;
            })
            .catch(function (error) {
              console.error(error);
            });
        });
    },
    resetStock: function () {
      this.stock = {
        on_hand: null,
        taken: null,
      };
    },
    reset: function () {
      this.product = {
        code: null,
        name: null,
        description: null,
      };
    },
    resetVal: function () {
      this.validationError = {
        code: null,
        name: null,
        description: null,
        on_hand: null,
      };
    },
    closeAndResetNewProduct: function () {
      this.newProductModal = false;
      this.editMode = false;
      this.reset();
      this.resetVal();
    },
    closeAndResetStockOnHand: function () {
      this.newStockAddModal = false;
      this.resetStock();
      this.resetVal();
    },
    saveStockOnHand: function () {
      this.$axios
        .get("/sanctum/csrf-cookie")
        .then((response) => {
          this.$axios
            .post("/api/savestock", this.product)
            .then((response) => {
              this.$refs.vuetable.refresh();
              this.closeAndResetStockOnHand();
            })
            .catch((error) => {
              if (error.response.status === 422) {
                for (var err in error.response.data.errors) {
                  this.validationError[err] =
                    error.response.data.errors[err][0];
                }
              } else {
                this.validationError.otherError =
                  "Something Went wrong, Your data Could not saved.";
              }
            });
        });
    },

    saveProduct: function () {
      this.$axios
        .get("/sanctum/csrf-cookie")
        .then((response) => {
          this.$axios
            .post("/api/products", this.product)
            .then((response) => {
              this.$refs.vuetable.refresh();
              this.closeAndResetNewProduct();
            })
            .catch((error) => {
              if (error.response.status === 422) {
                for (var err in error.response.data.errors) {
                  this.validationError[err] =
                    error.response.data.errors[err][0];
                }
              } else {
                this.validationError.otherError =
                  "Something Went wrong, Your data Could not saved.";
              }
            });
        });
    },
    updateProduct: function () {
      this.$axios
        .get("/sanctum/csrf-cookie")
        .then((response) => {
          this.$axios
            .put("/api/products", this.product)
            .then((response) => {
              this.$refs.vuetable.refresh();
              this.closeAndResetNewProduct();
            })
            .catch((error) => {
              if (error.response.status === 422) {
                for (var err in error.response.data.errors) {
                  this.validationError[err] =
                    error.response.data.errors[err][0];
                }
              } else {
                this.validationError.otherError =
                  "Something Went wrong, Your data Could not saved.";
              }
            });
        });
    },
    deleteProduct: function (id) {
      //  console.log(this.product);
      this.$axios
        .get("/sanctum/csrf-cookie")
        .then((response) => {
          this.$axios
            .delete("/api/products/destroy", {
              params: { id: id },
            })
            .then((response) => {
              this.$refs.vuetable.refresh();
              this.closeAndResetNewProduct();
            })
            .catch((error) => {
              this.validationError.otherError =
                "Something Went wrong, Your data Could not saved.";
            });
        });
    },
    onPaginationData(paginationData) {
      this.$refs.pagination.setPaginationData(paginationData);
    },
    onChangePage(page) {
      this.$refs.vuetable.changePage(page);
    },
    dataManager(sortOrder, pagination) {
      if (this.data.length < 1) return;

      let local = this.data;

      // sortOrder can be empty, so we have to check for that as well
      if (sortOrder.length > 0) {
        console.log("orderBy:", sortOrder[0].sortField, sortOrder[0].direction);
        local = _.orderBy(
          local,
          sortOrder[0].sortField,
          sortOrder[0].direction
        );
      }

      pagination = this.$refs.vuetable.makePagination(
        local.length,
        this.perPage
      );
      console.log("pagination:", pagination);
      let from = pagination.from - 1;
      let to = from + this.perPage;

      return {
        pagination: pagination,
        data: _.slice(local, from, to),
      };
    },
    onActionClicked(action, data) {
      console.log("slot actions: on-click", data.name);
      console.log(action);
      if (action == "add-stock") {
        this.newStockAddModal = true;
        this.product = data;
      }
      if (action == "edit-item") {
        this.newProductModal = true;
        this.editMode = true;
        this.product = data;
      }
      if (action == "delete-item") {
        this.deleteProduct(data.id);
      }
    },
  },
};
</script>

<style>
/* #app {
  font-family: "Avenir", Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  color: #2c3e50;
  margin-top: 20px;
} */
button.ui.button {
  padding: 8px 3px 8px 10px;
  margin-top: 1px;
  margin-bottom: 1px;
}
</style>
