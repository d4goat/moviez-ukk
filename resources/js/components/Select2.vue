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
    /* Selection */
    box-shadow: none;
    outline: none !important;
    @apply dark:bg-dropdown bg-white ;

    .select2-container--focus:not(.select2-container--disabled),
    .select2-container--open:not(.select2-container--disabled)
        .form-select-solid {
        min-width: 100% !important;
        @apply dark:bg-dropdown bg-white ;
    }

    .select2-container--disabled .form-select {
        @apply dark:bg-dropdown bg-white ;
    }

    .select2-search.select2-search--inline {
        flex-grow: 1;
    }

    .select2-search__field {
        color: #495057;
        font-weight: 400;
        font-family: inherit !important;
        background-color: transparent;
        border: 0;
        box-shadow: none;
        outline: none;
        line-height: 1;
        padding: 0.55rem 0.75rem;
    }

    .select2-selection--single {
        display: flex;
        height: auto !important;
        align-items: center;
        padding: 0.5rem;
        border-radius: 0.375rem;
        @apply dark:bg-dropdown bg-white border-[#6e6e6e] focus:ring-[#6e6e6e];
    }

    .select2-selection__rendered {
        display: block;
        height: auto !important;
        line-height: 1.5 !important;
        padding-left: 0;
        padding-right: 0;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .select2-selection__placeholder {
        color: #6c757d;
    }

    .select2-selection--multiple {
        display: flex;
        @apply dark:bg-dropdown bg-white border-[#6e6e6e] focus:ring-[#6e6e6e];
    }

    .select2-selection__choice {
        display: inline-flex;
        align-items: center;
        position: relative;
        background-color: #dee2e6;

        .select2-selection__choice__remove {
            display: block;
            width: 0.6rem;
            position: absolute;
            transform: translateY(-50%);
            opacity: 0.5;
        }
    }

    .select2-dropdown {
        border: 0;
        @apply dark:bg-dropdown bg-white;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 0.425rem;
        padding: 0.875rem;

        .select2-search {
            padding: 0.9rem 0.675rem;

            .select2-search__field {
                @apply dark:bg-component bg-white dark:text-[#828594] text-black;
                padding: 0.4rem 0.5rem;
                border: 1px solid #6e6e6e;
                border-radius: 0.425rem;
                outline: 0 !important;
            }
        }

        .select2-results__option {
            @apply text-dropdown dark:text-[#828594];
            padding: 0.7rem 0.5rem;
            margin: 0 0;

            &.select2-results__option--highlighted {
                @apply bg-sky-50 dark:bg-dropdown;
                @apply text-sky-600;
            }

            &.select2-results__option--selected {
                position: relative;
                @apply dark:bg-dropdown text-sky-700;

                &:after {
                    top: 50%;
                    display: block;
                    position: absolute;
                    transform: translateY(-50%);
                    height: 0.75rem;
                    width: 0.75rem;
                    content: "";
                    mask-position: center;
                    -webkit-mask-position: center;
                    right: 1.25rem;
                }
            }
        }
    }

    .select2-selection__clear {
        display: block;
        height: 0.6rem;
        width: 0.6rem;
        top: 50%;
        right: 1.2rem;
        position: absolute;
        transform: translateY(-50%);

        span {
            display: none;
        }
    }

    .select2-dropdown .select2-results > .select2-results__options {
        max-height: 250px;
        overflow-y: auto;
    }
}
</style>
