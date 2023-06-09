<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary card-header-icon">
            <div class="card-icon">
              <i class="material-icons">assignment</i>
            </div>
            <h4 class="card-title">
              <strong>{{ $t('cruds.pkabItem.title') }}</strong>
            </h4>
          </div>
          <div class="card-body">
            <router-link
              class="btn btn-primary"
              v-if="$can(xprops.permission_prefix + 'create')"
              :to="{ name: xprops.route + '.create' }"
            >
              <i class="material-icons">
                add
              </i>
              {{ $t('global.add') }}
            </router-link>
            <button
              type="button"
              class="btn btn-default"
              @click="fetchIndexData"
              :disabled="loading"
              :class="{ disabled: loading }"
            >
              <i class="material-icons" :class="{ 'fa-spin': loading }">
                refresh
              </i>
              {{ $t('global.refresh') }}
            </button>
            <export-excel v-if="$can('export')"
                :fields   = "dataFields"
                :data   = "jsonData">
                <button class="btn btn-success">Export</button>
            </export-excel>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <div class="table-overlay" v-show="loading">
                  <div class="table-overlay-container">
                    <material-spinner></material-spinner>
                    <span>Loading...</span>
                  </div>
                </div>
                <datatable
                  :columns="columns"
                  :data="data"
                  :total="total"
                  :query="query"
                  :xprops="xprops"
                  :HeaderSettings="false"
                  :pageSizeOptions="[10, 25, 50, 100]"
                >
                  <global-search :query="query" class="pull-left" />
                  <header-settings :columns="columns" class="pull-right" />
                </datatable>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
import PkabActions from '@components/Datatables/PkabActions'
import TranslatedHeader from '@components/Datatables/TranslatedHeader'
import HeaderSettings from '@components/Datatables/HeaderSettings'
import GlobalSearch from '@components/Datatables/GlobalSearch'
import DatatableSingle from '@components/Datatables/DatatableSingle'
import DatatableEnum from '@components/Datatables/DatatableEnum'
import BuDeptSingle from '@components/Datatables/BuDeptSingle'

export default {
  components: {
    GlobalSearch,
    HeaderSettings
  },
  data() {
    return {
      columns: [
        {
          title: 'cruds.pkabItem.fields.code',
          field: 'code',
          thComp: TranslatedHeader,
          sortable: true
        },
        {
          title: 'cruds.pkabItem.fields.created_at',
          field: 'created_at',
          thComp: TranslatedHeader,
          sortable: true
        },
        {
          title: 'cruds.pkabItem.fields.req_date',
          field: 'req_date',
          thComp: TranslatedHeader,
          sortable: true
        },
        {
          title: 'cruds.pkabItem.fields.user',
          field: 'user.name',
          thComp: TranslatedHeader,
          tdComp: DatatableSingle,
          sortable: true
        },
        {
          title: 'cruds.pkabItem.fields.status',
          field: 'status',
          thComp: TranslatedHeader,
          sortable: true,
          tdComp: DatatableEnum,
        },
        {
          title: 'cruds.pkabItem.fields.bu',
          field: 'bu.code',
          thComp: TranslatedHeader,
          tdComp: DatatableSingle,
          sortable: true
        },
        {
          title: 'cruds.pkabItem.fields.site',
          field: 'site.name',
          thComp: TranslatedHeader,
          tdComp: DatatableSingle,
          sortable: true
        },
        {
          title: 'cruds.pkabItem.fields.dept',
          field: 'dept.name',
          thComp: TranslatedHeader,
          tdComp: DatatableSingle,
          sortable: true
        },
        {
          title: 'global.actions',
          thComp: TranslatedHeader,
          tdComp: PkabActions,
          visible: true,
          thClass: 'text-right',
          tdClass: 'text-right td-actions'
        }
      ],
      query: { sort: 'status', order: 'asc', limit: 100, s: '' },
      xprops: {
        module: 'PkabItemsIndex',
        route: 'pkab_items',
        permission_prefix: 'pkab_item_'
      },
      dataFields : {
        'Kode' : 'code',
        'Tgl dibuat' : 'created_at',
        'Tgl dibutuhkan' : 'req_date',
        'User' : 'user.name',
        'BU' : 'bu.name',
        'Site' : 'site.name',
        'Dept' : 'dept.name',
        'Status' : 'status_label'
      }
    }
  },
  beforeDestroy() {
    this.resetState()
  },
  computed: {
    ...mapGetters('PkabItemsIndex', ['data', 'total', 'loading', 'jsonData']),
  },
  watch: {
    query: {
      handler(query) {
        this.setQuery(query)
        this.fetchIndexData()
      },
      deep: true
    }
  },
  methods: {
    ...mapActions('PkabItemsIndex', [
      'fetchIndexData',
      'setQuery',
      'resetState'
    ]),
  }
}
</script>