import Dropzone from "dropzone";

Dropzone.autoDiscover = false;

const dropzone = new Dropzone("#dropzone", {
    acceptedFiles: ".png, .jpg, .jpeg, .gif",
    addRemoveLinks: true,
    maxFiles: 1,
    uploadMultiple: false,
    maxFileSize: 2000000,
    init: function () {
        const addedImage = document
            .querySelector('[name="image"]')
            .value.trim();

        if (addedImage) {
            this.displayExistingFile(
                {
                    size: 1234,
                    name: addedImage,
                },
                `/uploads/${addedImage}`
            );
        }
    },
});

dropzone.on("success", function (file, response) {
    document.querySelector('[name="image"]').value = response.image;
});

dropzone.on("removedfile", function () {
    document.querySelector('[name="image"]').value = "";
});
