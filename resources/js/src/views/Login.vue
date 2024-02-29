<template>
<div class="container" style="height: 100vh;">
    <Form class="d-flex justify-content-center my-5" @submit="onSubmit" :validation-schema="validationSchema" ref="loginFrom">
        <div class="row">
            <div class="col-12 text-center">Login</div>
            <div class="col-12">
                <div class="mb-3">
                    <label class="form-label">Email </label>
                    <Field name="email" type="email" :rules="validateEmail" class="form-control" />
                    <ErrorMessage name="email" v-slot="{ message }">
                        <p class="text-danger">{{ message }}</p>
                    </ErrorMessage>
                </div>
            </div>
            <div class="col-12">
                <div class="mb-3">
                    <label class="form-label">Password </label>
                    <Field name="password" type="password" :rules="isRequired" class="form-control" />
                    <ErrorMessage name="password" v-slot="{message}">
                        <p class="text-danger">{{ message }}</p>
                    </ErrorMessage>
                </div>
            </div>
            <div class="col-12 text-center">
                <button class="btn btn-primary" type="submit">
                    Login
                </button>
            </div>
        </div>
    </Form>
</div>
</template>

<script>
import { Field, Form, ErrorMessage } from 'vee-validate'
import * as yup from 'yup';
export default {
    components: {
        Form,
        ErrorMessage,
        Field
    },
    data() {
        return {
            validationSchema: {
                email: yup.string().required().email(),
                password: yup.string().required(),
            }
        }
    },
    methods: {
        isRequired(value) {
            if (!value) {
                return 'This field is required'
            }
            return true
        },
        validateEmail(value) {
            if (!value) {
                return 'This field is required'
            }
            const regex = /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i
            if (!regex.test(value)) {
                return 'This field must be a valid email'
            }
            return true
        },
        onSubmit(values) {
            this.$http.post(`/api/login`, { ...values })
                .then((res) => {
                    this.$cookies.set('token', res.data.data.access_token);
                    this.$router.push('/products')
                })
                .catch((err) => {
                    const errors = err.response.data.errors;
                    console.log(errors);
                    Object.keys(errors).forEach((key) => {
                        this.$refs.loginFrom.setFieldError(key, errors[key][0]);
                    });

                });

        }
    }

}
</script>

<style>

</style>
