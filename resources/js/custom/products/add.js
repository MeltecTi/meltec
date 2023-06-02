"use strict";
import * as Filepond from "filepond";
import 'filepond/dist/filepond.min.css';
import FilePondPluginImagePreview from 'filepond-plugin-image-preview';
import FilePondPluginImageExifOrientation from 'filepond-plugin-image-exif-orientation';
import FilePondPluginFileValidateSize from 'filepond-plugin-image-validate-size';
import FilePondPluginImageEdit from 'filepond-plugin-image-edit';

document.addEventListener("DOMContentLoaded", () => {
    const image = document.querySelector("#image");

    Filepond.registerPlugin(
        FilePondPluginImagePreview,
        FilePondPluginImageExifOrientation,
        FilePondPluginFileValidateSize,
        FilePondPluginImageEdit
    );

    Filepond.create(
        image
    );
});
