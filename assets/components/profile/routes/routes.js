import kek from './../components/kek';
import lol from './../components/lol';
import componentNotFound from './../components/componentNotFound';


export const routes = [
  {
    name: 'kek',
    path: '/profile/kek/',
    component: kek,
  },
  {
    name: 'lol',
    path: '/profile/lol/',
    component: lol,
  },
  {
    path: "*",
    component: componentNotFound
  }
];
