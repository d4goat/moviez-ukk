import axios from "./axios";
import Swal from "sweetalert2";

interface ICallback {
    onSuccess?: Function;
    onError: Function;
    onSettled: Function;
}

export const useDelete = (callback?: ICallback, swalMixin?: any) => {
    const mySwal = Swal.mixin(
        swalMixin || {
            customClass: {
                confirmButton: "btn btn-danger btn-sm",
                cancelButton: "btn btn-secondary btn-sm",
            },
            buttonsStyling: false,
        },
    );
    const { onSuccess, onError, onSettled } = callback || {};

    return {
        delete: (url: string) =>
            mySwal
                .fire({
                    title: "Are you sure?",
                    text: "Deleted data cannot be restored!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, delete",
                    cancelButtonText: "Cancel",
                    reverseButtons: true,
                    preConfirm: () => {
                        return axios.delete(url).catch((error) => {
                            Swal.showValidationMessage(
                                error.response.data.message,
                            );
                        });
                    },
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        mySwal.fire(
                            "Success!",
                            result.value.data.message,
                            "success",
                        );
                        onSuccess && onSuccess();
                    }
                }),
    };
};
