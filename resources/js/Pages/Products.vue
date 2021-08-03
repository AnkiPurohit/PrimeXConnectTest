<template>
  <div>
    <h4 class="mb-3">Product List</h4>
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div v-if="success" class="alert alert-success" role="alert">
            {{ success }}
          </div>
          <div class="col-md-12">
            <b-button @click="newProductModal = !newProductModal" variant="dark"
              >Add New Product</b-button
            >
          </div>
        </div>
        <!-- Add/Update Product Modal  -->
        <b-modal
          id="newProductModal"
          ref="modal"
          v-bind:title="this.editMode ? 'Update Product' : 'Add new Product'"
          size="lg"
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

        <!-- Add Stock Modal -->
        <b-modal
          id="newStockAddModal"
          ref="modal"
          title="Add Stock On-Hand"
          size="lg"
          v-model="newStockAddModal"
          no-close-on-backdrop
          no-close-on-esc
          hide-header-close
        >
          <div class="form-group">
            <label for="productCode">Stock On Hand <span>*</span></label>
            <input
              type="number"
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
              type="number"
              class="form-control"
              id="taken"
              placeholder="Enter Stock Taken"
              v-model="stock.taken"
            /><br />
            <b-alert show v-if="validationError.taken" variant="danger">{{
              validationError.taken
            }}</b-alert>
          </div>
          <div class="form-group">
            <label for="productCode">Production Date </label>
            <input
              type="text"
              class="form-control"
              id="production_date"
              placeholder="DD/MM/YYYY"
              required
              pattern="[0-9]{2}/[0-9]{2}/[0-9]{4}"
              v-model="stock.production_date"
            /><br />
            <b-alert
              show
              v-if="validationError.production_date"
              variant="danger"
              >{{ validationError.production_date }}</b-alert
            >
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

        <!-- View Stock Summary for Selected Product Modal -->
        <b-modal
          id="sohListModal"
          ref="modal"
          title="Stock on hand Summary"
          size="lg"
          v-model="sohListModal"
          no-close-on-backdrop
          no-close-on-esc
          hide-header-close
        >
          <div class="row mt-2">
            <div class="col-md-12">Product: {{ product.name }}</div>
          </div>
          <div class="row mt-2">
            <div class="col-md-12">
              <table class="table table-bordered">
                <thead class="thead-light">
                  <tr>
                    <th>On Hand</th>
                    <th>Taken</th>
                    <th>Production Date</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="item in sohData" :key="item.id">
                    <td>
                      {{ item.on_hand }}
                    </td>
                    <td>
                      {{ item.taken }}
                    </td>
                    <td>
                      {{ item.production_date }}
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <template #modal-footer>
            <b-button size="sm" variant="danger" @click="closeSohList()">
              Close
            </b-button>
            <!-- Button with custom close trigger value -->
          </template>
        </b-modal>

        <div class="row mt-2">
          <div class="col-md-4">
            <div class="row">
              <div class="col-md-12">
                <label>Select Availability</label>
              </div>
            </div>  
            <div class="row">
              <div class="col-md-9">
                <select class="form-control" v-model="availability">
                  <option value="all">All</option>
                  <option value="yes">Available Products</option>
                  <option value="no">UnAvailable Products</option>
                </select>
              </div>
              <div class="col-md-3">
                <b-button @click="applyAvailabilityFilter" variant="outline-dark"
                >Apply</b-button
                >
              </div>
            </div>
          </div>
        </div>
        <div class="row"></div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <vuetable
          ref="vuetable"
          :api-url="apiUrl"
          pagination-path=""
          :css="css.table"
          :per-page="perPage"
          :fields="fields"
          :sort-order="sortOrder"
          @vuetable:pagination-data="onPaginationData"
          @vuetable:loaded="onLoaded"
          :query-params="{ sort: 'sort', page: 'page', perPage: 'size' }"
        >
          <div slot="actions" slot-scope="props">
            <button 
              class="btn btn-sm btn-outline-success"
              @click="onActionClicked('add-stock', props.rowData)"
            >
              <b-icon icon="plus" aria-hidden="true" variant="success"></b-icon>
            </button>
            <button
               class="btn btn-sm btn-outline-dark"
              @click="onActionClicked('show-stock', props.rowData)"
            >
              <b-icon icon="eye" aria-hidden="true" variant="dark"></b-icon>
            </button>
            <button
              class="btn btn-sm btn-outline-primary"
              @click="onActionClicked('edit-item', props.rowData)"
            >
              <b-icon icon="pencil-square" aria-hidden="true" variant="primary"></b-icon>
            </button>
            <button
              class="btn btn-sm btn-outline-danger"
              @click="onActionClicked('delete-item', props.rowData)"
            >
              <b-icon icon="trash-fill" aria-hidden="true" variant="danger"></b-icon>
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
      loading: true,
      sohListModal: false,
      editMode: false,
      success: false,
      availability: "all",
      apiUrl: "/api/products?stock=1",
      stock: {
        product_id: null,
        on_hand: null,
        taken: null,
        production_date: null,
      },
      product: {
        id: null,
        code: null,
        name: null,
        description: null,
      },
      validationError: {
        code: null,
        name: null,
        description: null,
        on_hand: null,
        production_date: null,
      },
      css: CssConfig,
      sortOrder: [
        {
          field: "total_on_hand",
          direction: "desc",
        },
      ],
      fields: [
        {
          name: "name",
          title: "Name",
        },
        {
          name: "code",
        },
        {
          name: "total_on_hand",
          title: "Stock On Hand",
          sortField: "total_on_hand",
        },
        {
          name: "total_taken",
          title: "Stock Taken",
        },
        {
          name: "available_stock",
          title: "Availabile Stock",
        },

        "description",
        "actions",
      ],

      perPage: 10,
      data: [],
      sohData: [],
    };
  },

  watch: {
    data(newVal, oldVal) {
      this.$refs.vuetable.refresh();
    },
  },

  mounted() {
  },

  methods: {
    makeQueryParams: function (sortOrder, currentPage, perPage) {
      return {
        sort: sortOrder,
        page: currentPage,
        size: perPage
      }
    },
    onLoaded: function () {
      this.loading = false;
    },

    applyAvailabilityFilter: function () {
      if (this.availability == "all") {
        this.apiUrl = "/api/products?stock=1";
      } else {
        this.apiUrl = "/api/products?stock=1&availability=" + this.availability;
      }
    },

    getProductData: function () {
      this.$axios
        .get("/sanctum/csrf-cookie")
        .then((response) => {
          this.$axios
            .get("/api/products?stock=1")
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
        production_date: null,
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
      this.reset();
      this.resetVal();
    },
    closeSohList: function () {
      this.sohListModal = false;
    },
    saveStockOnHand: function () {
      this.resetVal();
      this.$axios
        .get("/sanctum/csrf-cookie")
        .then((response) => {
          this.$axios
            .post("/api/stock", this.stock)
            .then((response) => {
              this.$refs.vuetable.refresh();
              this.closeAndResetStockOnHand();
              this.success = response.data.success;
              setTimeout(() => this.success = false, 2000);
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
              this.success = response.data.success;
              setTimeout(() => this.success = false, 2000);

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
              this.success = response.data.success;
              setTimeout(() => this.success = false, 2000);

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
              this.success = response.data.success;
              setTimeout(() => this.success = false, 2000);
            })
            .catch((error) => {
              this.validationError.otherError =
                "Something Went wrong, Your data Could not saved.";
            });
        });
    },
    showStockSummary: function (id) {
      this.$axios
        .get("/sanctum/csrf-cookie")
        .then((response) => {
          this.$axios
            .get("/api/stock/", {
              params: { product_id: id },
            })
            .then((response) => {
              this.sohData = response.data;
              console.log(this.sohData);
              console.log("help");
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
      console.log("slot actions: on-click", data.id);
      console.log(action);
      if (action == "add-stock") {
        this.newStockAddModal = true;
        this.product = data;
        this.stock.product_id = data.id;
      }
      if (action == "edit-item") {
        this.newProductModal = true;
        this.editMode = true;
        this.product = data;
      }
      if (action == "delete-item") {
        this.deleteProduct(data.id);
      }
      if (action == "show-stock") {
        this.showStockSummary(data.id);
        this.sohListModal = true;
        this.product = data;
      }
    },
  },
};
</script>

<style>

button.ui.button {
  padding: 8px 3px 8px 10px;
  margin-top: 1px;
  margin-bottom: 1px;
}
</style>
