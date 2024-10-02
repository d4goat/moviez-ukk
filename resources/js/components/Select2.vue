<template>
    <div>
        <select
            class="form-control form-select"
            :id="id"
            :name="name"
            :disabled="disabled"
            :required="required"
        ></select>
    </div>
</template>

<script>
import select2 from "select2/dist/js/select2.full.js";
select2();
import "select2/dist/css/select2.min.css";
import $ from "jquery";

export default {
    name: "Select2",
    data() {
        return {
            select2: null,
        };
    },
    emits: ["update:modelValue", "select"],
    props: {
        modelValue: [String, Array, Number], // previously was `value: String`
        id: {
            type: String,
            default: "",
        },
        name: {
            type: String,
            default: "",
        },
        placeholder: {
            type: String,
            default: "",
        },
        options: {
            type: Array,
            default: () => [],
        },
        disabled: {
            type: Boolean,
            default: false,
        },
        required: {
            type: Boolean,
            default: false,
        },
        settings: {
            type: Object,
            default: () => {},
        },
        class: {
            type: String,
            default: "",
        },
    },
    watch: {
        options: {
            handler(val) {
                this.setOption(val);
            },
            deep: true,
        },
        modelValue: {
            handler(val) {
                this.setValue(val);
            },
            deep: true,
        },
    },
    methods: {
        setOption(val = []) {
            this.select2?.empty();
            this.select2?.select2({
                ...this.settings,
                placeholder: this.placeholder,
                containerCssClass: `form-select ${this.class}`,
                data: val,
            });
            this.setValue(this.modelValue);
            this.select2
                ?.data()
                .select2.$selection.addClass(`form-select ${this.class}`);
        },
        setValue(val) {
            if (val instanceof Array) {
                this.select2?.val([...val]);
            } else {
                this.select2?.val([val]);
            }
            this.select2?.trigger("change");
        },
    },
    mounted() {
        this.select2 = $(this.$el)
            .find("select")
            .select2({
                ...this.settings,
                placeholder: this.placeholder,
                containerCssClass: `form-select ${this.class}`,
                data: this.options,
            })
            .on("select2:select select2:unselect", (ev) => {
                this.$emit("update:modelValue", this.select2.val());
                this.$emit("select", ev["params"]["data"]);
            });
        this.setValue(this.modelValue);
        this.select2
            ?.data()
            .select2.$selection.addClass(`form-select ${this.class}`);
    },
    beforeUnmount() {
        this.select2?.select2("destroy");
    },
};
</script>

<style>
.select2-container--default {
    width: auto;

    .select2-selection {
      box-shadow: none;
      height: auto !important;
      outline: none !important;
    }
  
    .select2-container--default .select2-selection--single,
    .select2-container--default .select2-selection--multiple {
        @apply bg-transparent dark:bg-component; 
        border-color: #e5e7eb; 
        color: #374151;
    }
    
    .select2-selection--single {
      display: flex;
      align-items: center;
      padding: 0.5rem;
      border-radius: 0.375rem;
    }
  
    .select2-selection--multiple {
      display: flex;
      align-items: center;
      flex-wrap: wrap;
      padding: 0.5rem;
      border-radius: 0.375rem;
    }
  
    .select2-selection__rendered {
      color: inherit;
      line-height: 1.5 !important;
    }
  
    .select2-selection__choice {
      display: inline-flex;
      align-items: center;
      background-color: #d1d5db;
      color: #1f2937;
    }
  
    .select2-selection__choice__remove {
      background-color: #374151;
      color: #f9fafb;
      transition: background-color 0.2s ease;
  
      &:hover {
        background-color: #3b82f6;
      }
    }
  
    .select2-dropdown {
      border: 0;
      width: 5vw !important;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.5); 
      border-radius: 0.275rem;
      padding: 1rem 0;
      @apply dark:bg-dropdown bg-white;
  
      .select2-search {
        padding: 0.5rem 1.25rem;
  
        .select2-search__field {
          @apply dark:bg-component bg-white dark:text-[#828594] text-black;
          padding: 0.55rem 0.75rem;
          border: 1px solid #d1d5db;
          border-radius: 0.425rem;
          outline: 0 !important;
  
          &::placeholder {
            color: #1b1c21;
          }
        }
      }
  
      .select2-results__option {
        @apply text-dropdown dark:text-[#828594];
        padding: 0.75rem 1.25rem;
        margin: 0 0;
  
        &.select2-results__option--highlighted {
          @apply bg-sky-50 dark:bg-dropdown;
          @apply text-sky-600;
        }
  
        &.select2-results__option--selected {
          @apply dark:bg-dropdown text-sky-700;
        }
      }
    }
  }
  
</style>