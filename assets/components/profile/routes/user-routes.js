import settings from '../components/settings/userSettings';
import messages from '../components/messages/messages';
import training from '../components/trainig/training';

export const routes = [
  {
    name: 'settings',
    path: '/profile/settings/',
    component: settings,
  },
  {
    name: 'messages',
    path: '/profile/messages/',
    component: messages,
  },
  {
    name: 'training',
    path: '/profile/training',
    component: training,
  },
  {
    path: '*',
    redirect: '/profile/settings/'
  }
];
