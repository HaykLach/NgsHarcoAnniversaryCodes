import template from './index.html.twig';

const { Component } = Shopware;

Component.register('ngs-harco-participants-import', {
    template,
    data() {
        return {
            file: null,
            result: null
        };
    },
    methods: {
        onChangeFile(event) {
            this.file = event.target.files[0];
        },
        onUpload() {
            if (!this.file) {
                return;
            }
            const formData = new FormData();
            formData.append('file', this.file);
            this.$http.post('/_action/ngs-harco/participants/import', formData).then(response => {
                this.result = response.data;
            });
        }
    }
});
