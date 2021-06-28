Yii Framwork
1, ActiveForm: Dùng để tạo From Input
2, Sử dụng Gii:
    Tạo migrations trước	
    Model Generator: Tạo model
3, Truy vấn request:
    C1:
    $model = new \app\models\ContactForm;
    $data = \Yii::$app->request->post('ContactForm', []);
    Truy cap $_POST['name'] thi dung $data['name']
    
    C2: Dùng Yii::$app->request
    $request = Yii::$app->request;
    $name = $request->post('EntryForm')['name'];

    Nếu là GET: (http://localhost/yii-framwork-basic/web/site/entry?id=1) -> Chỉ lấy được query (sau dấu ?)
    $id = $request->get('id'); -> 1
4, Session:
    $session = Yii::$app->session;
    $session['language'] = 'en-US'; TẠO
    unset($session['language']); XÓA
    $session->has('language') KIỂM TRA 
    print_r($session['language']); LẤY RA SESSION

5, Yii::$app->homeUrl: Xuất đường dẫn gốc của Project

6, Query SQL: Yii::$app->db->createCommand('CAU LENH SQL')
    6.1: Query với câu lệnh SQL
    - queryAll() : ALL Bản ghi (Yii::$app->db->createCommand('SELECT * FROM country')->queryAll())
    - queryOne() : Lấy 1 bản ghi (Yii::$app->db->createCommand('SELECT * FROM country WHERE code = "AU"')->queryOne())
    - queryColumn() : Lấy 1 cột trong bảng (Yii::$app->db->createCommand('SELECT name FROM country')->queryColumn())
    - queryScalar() : Các truy vấn khác như lấy tổng số bản ghi trong bảng (Yii::$app->db->createCommand('SELECT COUNT(*) FROM country')->queryScalar())
    
    - bindValue(), bindValues(), bindParam() : Ràng buộc tham số vào câu lệnh SQL
        $post = Yii::$app->db->createCommand('SELECT * FROM country WHERE code=:code AND population=:population')
        ->bindValue(':code', $_GET['code'] ?? 'VI')
        ->bindValue(':population', 84)
        ->queryOne();

        bindValue() và bindValues() Là ràng buộc giá trị cụ thể
        bindParam() Là ràng buộc với biến $
    - execute() : Để câu lệnh SQL không trả về dữ liệu (Dùng cho POST, PUT, DELETE,...)



    batchInsert() : Tạo nhiều bản ghi cùng 1 lúc
    upsert(): Tạo nếu kho có hoặc Update nếu có bản ghi

    6.2: Query với (new \yii\db\Query())
    $country = (new \yii\db\Query())->select(['code', 'name'])->from('country')->all();

    6.3: Query với Active Record (Models)
    ModelName::find()
    - all(): Lấy tất cả bản ghi
    - one(): Lấy bản ghi đầu tiên
    - count(): Số bản ghi

    - findAll() : Tất cả bản ghi (Yêu cầu bắt buộc phải có điều kiện truy vấn)
    - findOne() : Lấy 1 bản ghi (Yêu cầu bắt buộc phải có điều kiện truy vấn)
    - findBySql() : Viết câu lệnh SQL thô

    - asArray() : Chuyển thành mảng, giảm thiểu nội dung, tiết kiệm bộ nhớ
    NHƯNG asArray() PHẢI LUÔN ĐỨNG SAU (TRONG MỐI QUAN HỆ)

7, Mối quan hệ: Khá giống Laravel   
    Khi muốn truy vấn MỐI QUAN HỆ, ta sử dụng tên biến viết thường ở phía sau getVarName()

8, Migration
- php yii migrate/create 
- php yii migrate