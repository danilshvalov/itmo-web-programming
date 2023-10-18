#include "website_form.hpp"

#include <QVBoxLayout>

WebsiteForm::WebsiteForm(QWidget* parent) : QMainWindow(parent) {
    url_label_ = new QLabel(this);
    url_label_->setText("URL");

    show_time_label_ = new QLabel(this);
    show_time_label_->setText("Время демонстрации, с");

    url_validator_ = new UrlValidator(this);

    url_input_ = new QLineEdit(this);
    QObject::connect(
        url_input_, &QLineEdit::textChanged, this, &WebsiteForm::onInput
    );
    url_input_->setValidator(url_validator_);

    show_time_input_ = new QSpinBox(this);
    show_time_input_->setMinimum(3);
    show_time_input_->setMaximum(15);
    show_time_input_->setValue(5);

    submit_button_ = new QPushButton(this);
    submit_button_->setText("Сохранить");
    submit_button_->setFixedHeight(50);
    QObject::connect(
        submit_button_, &QPushButton::clicked, this, &WebsiteForm::onSubmit
    );

    QVBoxLayout* layout = new QVBoxLayout();
    layout->addWidget(url_label_);
    layout->addWidget(url_input_);
    layout->addWidget(show_time_label_);
    layout->addWidget(show_time_input_);
    layout->addWidget(submit_button_);

    QWidget* widget = new QWidget(this);
    widget->setLayout(layout);

    setCentralWidget(widget);

    clear();
}

void WebsiteForm::setFields(WebsiteDisplayInfo info) {
    url_input_->setText(info.url.toString());
    show_time_input_->setValue(info.show_time / 1000);
    submit_button_->setEnabled(url_input_->hasAcceptableInput());
}

void WebsiteForm::clear() {
    row_ = -1;
    url_input_->clear();
    show_time_input_->clear();
    submit_button_->setDisabled(true);
}

void WebsiteForm::onInput() {
    submit_button_->setEnabled(url_input_->hasAcceptableInput());
}

void WebsiteForm::onSubmit(bool) {
    emit submit(WebsiteDisplayInfo{
        QUrl::fromUserInput(url_input_->text()),
        show_time_input_->value() * 1000,
    });
    close();
}

int WebsiteForm::getRow() const { return row_; }

void WebsiteForm::setRow(int row) { row_ = row; }
