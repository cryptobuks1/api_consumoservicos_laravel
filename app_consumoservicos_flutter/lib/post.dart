class Post{

  int _userId;
  int _id;
  String _title;
  String _body;

  Post(this._id, this._userId, this._title, this._body);

  Map toJson(){
    return {
      "id": this._id,
      "userId": this._userId,
      "title": this._title,
      "body": this._body
    };
  }

  //ID
  int get id => _id;

  set id(int value) {
    _id = value;
  }

  //USER_ID
  int get userId => _userId;

  set userId(int value) {
    _userId = value;
  }

  //TITLE
  String get title => _title;

  set title(String value) {
    _title = value;
  }

  //BODY
  String get body => _body;

  set body(String value) {
    _body = value;
  }


}