import settings from '../components/settings';
import programs from '../components/programs';
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
    component: programs,
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
