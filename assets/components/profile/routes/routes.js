import settings from '../components/settings';
import programsList from '../components/programs/programList';
import requestList from '../components/programs/requestList';
import publications from '../components/publications';
import messages from '../components/messages';
import services from '../components/services';
import training from '../components/training';
import componentNotFound from './../components/componentNotFound';

export const routes = [
  {
    name: 'settings',
    path: '/profile/settings/',
    component: settings,
  },
  {
    name: 'programs',
    path: '/profile/programs/',
    component: programsList,
  },
  {
    name: 'programs-requests',
    path: '/profile/programs/request/:id',
    component: requestList,
    props: true,
  },
  {
    name: 'publications',
    path: '/profile/publications/',
    component: publications,
  },
  {
    name: 'messages',
    path: '/profile/messages/',
    component: messages,
  },
  {
    name: 'services',
    path: '/profile/services/',
    component: services,
  },
  {
    name: 'training',
    path: '/profile/training/',
    component: training,
  },
  {
    path: '*',
    component: componentNotFound
  }
];
