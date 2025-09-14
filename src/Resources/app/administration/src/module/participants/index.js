import './page/participants-import';

Shopware.Module.register('ngs-harco-participants', {
    type: 'plugin',
    name: 'Participants',
    title: 'Participants',
    description: 'Import participants',
    color: '#ff3d58',
    icon: 'default-communication-mail',
    routes: {
        index: {
            component: 'ngs-harco-participants-import',
            path: 'index'
        }
    },
    navigation: [
        {
            label: 'Participants',
            color: '#ff3d58',
            path: 'ngs.harcoparticipants.index',
            icon: 'default-communication-mail',
            parent: 'sw-marketing',
            position: 100
        }
    ]
});
