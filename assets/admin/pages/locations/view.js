import React from 'react';

class LocationView extends React.Component {
  componentDidMount() {
    const {
      match: {params}
    } = this.props;
console.log(params)
    // axios.get(`/api/users/${params.userId}`)
    //   .then(({data: user}) => {
    //     console.log('user', user);
    //
    //     this.setState({user});
    //   });
  }

  render() {
    console.log(this.props)
    return (
      <div className="page">
        kek
      </div>
    )
  }
}

export default LocationView;
