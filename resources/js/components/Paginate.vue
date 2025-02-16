<template>
    <div :id="id">
      <div class="flex justify-between gap-2 flex-wrap mb-4">
        <div class="flex gap-4 items-center">
          <label htmlfor="limit" class="form-label">
            Showing of
          </label>
          <select2
            class="w-22 form-select-solid"
            v-model="per"
            placeholder="Per"
            :options="[5, 10, 25, 50, 100]"
          >
          </select2>
        </div>
        <form @submit.prevent="refetch" class="w-full sm:w-auto">
          <input
            type="search"
            class="text-gray-500 rounded-md bg-[#222329] focus:ring-0 focus:border-none border-none"
            placeholder="Search ..."
            v-model="search"
            v-debounce="onSearch"
          />
        </form>
      </div>

      <div class="overflow-x-auto mt-4 table-auto">
        <table class="min-w-full rounded">
          <thead class="">
            <tr
              v-for="headerGroup in table.getHeaderGroups()"
              :key="headerGroup.id"
              class="text-left bg-[#222329] text-gray-300"
            >
              <th
                v-for="header in headerGroup.headers"
                :key="header.id"
                class="px-4 py-3 font-medium"
              >
                <FlexRender
                  :render="header.isPlaceholder ? null : header.column.columnDef.header"
                  :props="header.getContext()"
                />
              </th>
            </tr>
          </thead>
          <tbody>
            <template v-if="!!data?.data?.length">
              <tr
                v-for="row in table.getRowModel().rows"
                :key="`row.${row.original.uuid}`"
                class="hover:bg-[#212228] bg-[#1a1c21]"
              >
                <td
                  v-for="cell in row.getVisibleCells()"
                  :key="`cell.${cell.id}.${cell.row.original.uuid}`"
                  class="p-4"
                >
                  <FlexRender
                    :render="cell.column.columnDef.cell"
                    :props="cell.getContext()"
                  />
                </td>
              </tr>
            </template>
            <tr v-else>
              <td :colspan="columns.length" class="text-center py-4">
                Data not found
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="flex justify-between mt-4 flex-wrap gap-2">
        <div class="text-gray-700 text-sm">
          Showing {{ data?.from }} to {{ data?.to }} of {{ data?.total }} results
        </div>
        <ul class="flex gap-2">
          <li
            class="py-1 px-[12px] rounded-md"
            :class="{ 'opacity-50 pointer-events-none': data?.current_page == 1 || !data }"
          >
            <span
              @click="page = data?.current_page - 1"
              class="page-link cursor-pointer"
            >
              <i class="fa fa-angle-left"></i>
            </span>
          </li>
          <li
            v-for="item in pagination"
            :key="item"
            @click="page = item"
            class="py-1 px-[12px] rounded-md"
            :class="{ 'bg-blue-600 text-white': item === page }"
          >
            <span class="page-link cursor-pointer">{{ item }}</span>
          </li>
          <li
            class="py-1 px-[12px] rounded-md"
            :class="{ 'opacity-50 pointer-events-none': data?.current_page == data?.last_page || !data }"
          >
            <span
              @click="page = data?.current_page + 1"
              class="page-link cursor-pointer"
            >
              <i class="fa fa-angle-right"></i>
            </span>
          </li>
        </ul>
      </div>
    </div>
  </template>


<script>
import { useQuery } from "@tanstack/vue-query";
import { ref, defineComponent } from "vue";
import {
    useVueTable,
    FlexRender,
    getCoreRowModel,
} from "@tanstack/vue-table";
import axios from "@/libs/axios";
import { block, unblock } from "@/libs/utils";
import { toast } from "vue3-toastify";
import $ from "jquery";

export default defineComponent({
    props: {
        id: {
            type: String,
            required: true
        },
        columns: {
            type: Array,
            required: true,
            default: () => []
        },
        url: {
            type: String,
            required: true
        },
        payload: {
            type: Object,
            default: {}
        },
        queryKey: {
            type: String,
            default: null
        },
        enabled: {
            type: Boolean,
            default: true
        }
    },
    components: {
        FlexRender
    },
    setup(props) {
        const search = ref("");
        const debouncedSearch = ref("");

        const per = ref(10);
        const page = ref(1);

        const { data = {}, isFetching, refetch } = useQuery({
            queryKey: [props.queryKey || props.url],
            queryFn: () => axios.post(props.url, {
                search: search.value,
                page: page.value,
                per: parseInt(per.value),
                ...props.payload
            }).then(res => res.data),
            placeholderData: { data: [] },
            cacheTime: 0,
            enabled: props.enabled,
            onSuccess: (data) => {
                if (page.value > data.last_page) page.value = data.last_page;
            },
            onError: (err) => {
                toast.error(err.response.data.message);
            }
        });

        const table = useVueTable({
            get data() {
                return data.value.data
            },
            columns: props.columns,
            getCoreRowModel: getCoreRowModel(),
        });

        return {
            search, debouncedSearch,
            table,
            per, page,
            data,
            isFetching,
            refetch
        }
    },
    methods: {
        onSearch() {
            this.debouncedSearch = this.search;
        },
    },
    watch: {
        page() {
            this.refetch();
        },
        per() {
            this.refetch();
        },
        debouncedSearch() {
            this.refetch();
        },
        isFetching(val) {
            if (val && !document.querySelector(`#${this.id} table`).querySelector(".blockui-overlay")) block(`#${this.id} table`);
            else unblock(`#${this.id} table`);
        },
        payload(val, oldVal) {
            if (JSON.stringify(val) !== JSON.stringify(oldVal)) this.refetch();
        }
    },
    computed: {
        pagination() {
            let limit = this.data?.last_page <= this.page + 1 ? 5 : 2;
            return Array.from({ length: this.data?.last_page }, (_, i) => i + 1).filter(
                (i) =>
                    i >= (this.page < 3 ? 3 : this.page) - limit && i <= (this.page < 3 ? 3 : this.page) + limit
            )
        }
    },
    mounted() {
        block(`#${this.id} table`);
    }
})
</script>

<style scoped>
:deep(.select2-container--default) {
  width: auto !important;
  min-width: fit-content;
}

:deep(.select2-container--default .select2-selection--single),
:deep(.select2-container--default .select2-selection--multiple) {
  min-width: 100%;
}

:deep(.select2-container--default .select2-dropdown) {
  min-width: 100%;
  width: auto !important;
  max-width: none;
}

:deep(.select2-container--default .select2-results) {
  min-width: fit-content;
}

:deep(.select2-container--default .select2-results__options) {
  white-space: nowrap;
}

:deep(.select2-container--default .select2-results__option) {
  padding: 0.75rem 1.25rem;
}

/* Override untuk select dengan lebar kecil */
:deep(.w-22.select2-container),
:deep(.w-22 + .select2-container) {
  width: 5rem !important;
  min-width: 5rem !important;
}

:deep(.w-22 + .select2-container .select2-dropdown) {
  min-width: 5rem;
  max-width: none;
}
</style>
