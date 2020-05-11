import settings from '../components/settings/userSettings';
import messages from '../components/messages/messages';
import componentNotFound from './../components/componentNotFound';

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
    path: '*',
    component: componentNotFound
  }
];
