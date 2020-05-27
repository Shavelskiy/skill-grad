import React, {useState, useEffect} from 'react';
import Breadcrumbs from '../../components/breadcrumbs/breacrumbs';
import Table from '../../components/table/table';
import Paginator from '../../components/paginator/paginator';
import Search from '../../components/search/search';
import PanelTitle from '../../components/panel/panel-title';
import axios from 'axios';

const breadcrumbs = [
  {
    title: 'Главная',
    link: '/',
  },
  {
    title: 'Список тегов',
    link: null,
  },
];

const table = [
  {
    title: 'Id',
    name: 'id',
  },
  {
    title: 'Название',
    name: 'name',
  },
  {
    title: 'Сортировка',
    name: 'sort',
  }
];

const actions = [
  {
    type: 'view',
    link: '/tag',
  },
  {
    type: 'update',
    link: '/tag',
  }
];

const TagsIndex = () => {
  const [body, setBody] = useState([]);
  const [paginatorRequest, setPaginatorRequest] = useState(null);
  const [disabledTable, setDisabledTable] = useState(false);
  const [totalPages, setTotalPages] = useState(0);
  const [currentPage, setCurrentPage] = useState(1);
  const [order, setOrder] = useState({});

  useEffect(() => loadItems(), []);

  const loadItems = () => {
    const axiosSource = axios.CancelToken.source();

    if (paginatorRequest) {
      paginatorRequest.cancel();
    }

    setPaginatorRequest({cancel: axiosSource.cancel});
    setDisabledTable(true);

    const params = {
      page: currentPage,
      order: order,
    };

    axios.get('/api/admin/tag', {
      cancelToken: axiosSource.token,
      params: params,
    })
      .then(({data}) => {
        setBody(data.items);
        setTotalPages(data.total_pages);
        setCurrentPage(data.current_page);
        setDisabledTable(false);
      });
  }

  const changePage = (page) => {
    if (page === currentPage) {
      return;
    }

    setCurrentPage(page);
    loadItems();
  }

  const changeOrder = (propName) => {
    if (!order[propName]) {
      order[propName] = null;
    }

    switch (order[propName]) {
      case null:
        order[propName] = 'asc';
        break;
      case 'asc':
        order[propName] = 'desc';
        break;
      case 'desc':
        delete order[propName];
        break;
    }

    setOrder(order);
    loadItems();
  }

  return (
    <div>
      <Breadcrumbs items={breadcrumbs}/>

      <div className="portlet">
        <PanelTitle
          title={'Список тегов'}
          icon={'fa fa-tags'}
          withButton={true}
          buttonText={'Создать'}
          buttonLink={'/tag/create'}
        />

        <div className="body">
          {/*<Search/>*/}
          <Table
            table={table}
            body={body}
            order={order}
            disabled={disabledTable}
            changeOrder={(propName) => changeOrder(propName)}
            actions={actions}
          />
          <Paginator
            totalPages={totalPages}
            currentPage={currentPage}
            click={(page) => changePage(page)}
          />
        </div>
      </div>
    </div>
  );
};

export default TagsIndex;
